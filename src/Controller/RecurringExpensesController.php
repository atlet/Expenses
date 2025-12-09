<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\FrozenDate;

class RecurringExpensesController extends AppController {
    public function index() {
        $recurringExpenses = $this->RecurringExpenses->find('all')
            ->contain(['PaidBy', 'RecurringExpenseSplits.People'])
            ->where(['is_active' => true]);

        // Preveri, kateri stroški potrebujejo opomnik
        $reminders = [];
        $today = FrozenDate::now();

        foreach ($recurringExpenses as $recurring) {
            $needsReminder = false;

            if ($recurring->last_added_date) {
                $lastAdded = $recurring->last_added_date;
                // Če ni bil dodan ta mesec
                if ($lastAdded->month != $today->month || $lastAdded->year != $today->year) {
                    // In če je že prešel dan v mesecu
                    if ($today->day >= $recurring->day_of_month) {
                        $needsReminder = true;
                    }
                }
            } else {
                // Še nikoli ni bil dodan
                if ($today->day >= $recurring->day_of_month) {
                    $needsReminder = true;
                }
            }

            if ($needsReminder) {
                $reminders[] = $recurring->id;
            }
        }

        $this->set(compact('recurringExpenses', 'reminders'));
    }

    public function add() {
        $recurringExpense = $this->RecurringExpenses->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();

            // Pripravi recurring expense splits
            $splitPeople = $data['split_people'] ?? [];
            $splits = [];
            foreach ($splitPeople as $personId) {
                $splits[] = [
                    'person_id' => $personId
                ];
            }
            $data['recurring_expense_splits'] = $splits;

            $recurringExpense = $this->RecurringExpenses->patchEntity($recurringExpense, $data, [
                'associated' => ['RecurringExpenseSplits']
            ]);

            if ($this->RecurringExpenses->save($recurringExpense)) {
                $this->Flash->success(__('Ponavljajoči se strošek je bil dodan.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Ponavljajočega se stroška ni bilo mogoče dodati. Prosim poskusite ponovno.'));            
        }

        $people = $this->RecurringExpenses->PaidBy->find('list');
        $this->set(compact('recurringExpense', 'people'));
    }

    public function createExpense($id = null) {
        $this->request->allowMethod(['post']);

        $recurringExpense = $this->RecurringExpenses->get($id, contain: ['RecurringExpenseSplits']);

        // Ustvari nov expense iz recurring expense
        $expenseData = [
            'title' => $recurringExpense->title,
            'amount' => $recurringExpense->amount,
            'commission' => $recurringExpense->commission,
            'expense_date' => FrozenDate::now(),
            'paid_by_id' => $recurringExpense->paid_by_id,
        ];

        // Dodaj expense splits
        $shareRatio = count($recurringExpense->recurring_expense_splits) > 0
            ? 1 / count($recurringExpense->recurring_expense_splits)
            : 0;

        $expenseSplits = [];
        foreach ($recurringExpense->recurring_expense_splits as $split) {
            $expenseSplits[] = [
                'person_id' => $split->person_id,
                'share_ratio' => $shareRatio
            ];
        }
        $expenseData['expense_splits'] = $expenseSplits;

        $expense = $this->RecurringExpenses->PaidBy->Expenses->newEntity($expenseData, [
            'associated' => ['ExpenseSplits']
        ]);

        if ($this->RecurringExpenses->PaidBy->Expenses->save($expense)) {
            // Posodobi last_added_date
            $recurringExpense->last_added_date = FrozenDate::now();
            $this->RecurringExpenses->save($recurringExpense);

            $this->Flash->success(__('Strošek je bil dodan iz ponavljajočega se stroška.'));
        } else {
            $this->Flash->error(__('Stroška ni bilo mogoče dodati. Prosim poskusite ponovno.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $recurringExpense = $this->RecurringExpenses->get($id);
        if ($this->RecurringExpenses->delete($recurringExpense)) {
            $this->Flash->success(__('Ponavljajoči se strošek je bil izbrisan.'));
        } else {
            $this->Flash->error(__('Ponavljajočega se stroška ni bilo mogoče izbrisati. Prosim poskusite ponovno.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
