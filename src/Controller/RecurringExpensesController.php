<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\FrozenDate;

class RecurringExpensesController extends AppController {
    public function index() {
        $recurringExpenses = $this->RecurringExpenses->find('all')
            ->contain(['PaidBy', 'RecurringExpenseSplits.People'])
            ->orderBy(['RecurringExpenses.title' => 'ASC']);

        // Preveri, kateri stroški potrebujejo opomnik
        $reminders = [];
        $today = new \Cake\I18n\Date((new \DateTimeImmutable('today', new \DateTimeZone('Europe/Ljubljana')))->format('Y-m-d'));

        foreach ($recurringExpenses as $recurring) {
            $needsReminder = false;

            if ($recurring->last_added_date) {
                $lastAdded = $recurring->last_added_date;
                // Če ni bil dodan ta mesec
                if ($lastAdded->month != $today->month || $lastAdded->year != $today->year) {
                    // In če je že prešel dan v mesecu
                    if ($recurring->is_active && $today->day >= min($recurring->day_of_month, (int)$today->format('t'))) {
                        $needsReminder = true;
                    }
                }
            } else {
                // Še nikoli ni bil dodan
                if ($recurring->is_active && $today->day >= min($recurring->day_of_month, (int)$today->format('t'))) {
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
            foreach (array_unique(array_filter($splitPeople)) as $personId) {
                $splits[] = [
                    'person_id' => $personId
                ];
            }
            $data['recurring_expense_splits'] = $splits;

            $recurringExpense = $this->RecurringExpenses->patchEntity($recurringExpense, $data, [
                'associated' => ['RecurringExpenseSplits']
            ]);

            if ($this->RecurringExpenses->save($recurringExpense)) {
                $this->Flash->success(__('A recurring cost has been added.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('A recurring cost could not be added. Please try again.'));            
        }

        $people = $this->RecurringExpenses->PaidBy->find('list');
        $categories = $this->RecurringExpenses->ExpenseCategories->find('list')->where(['is_active' => true])->orderBy(['sort_order' => 'ASC']);
        $this->set(compact('recurringExpense', 'people', 'categories'));
    }

    public function edit($id = null) {
        $recurringExpense = $this->RecurringExpenses->get($id, contain: ['RecurringExpenseSplits']);
        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = $this->request->getData();
            $data['recurring_expense_splits'] = array_map(
                fn($id) => ['person_id' => $id],
                array_values(array_unique(array_filter($data['split_people'] ?? [])))
            );
            $this->RecurringExpenses->patchEntity($recurringExpense, $data, [
                'fields' => ['expense_category_id', 'title', 'amount', 'commission', 'day_of_month', 'paid_by_id', 'is_active', 'recurring_expense_splits'],
                'associated' => ['RecurringExpenseSplits'],
            ]);
            if ($this->RecurringExpenses->save($recurringExpense)) {
                $this->Flash->success(__('Saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Please check the entered values.'));
        }
        $people = $this->RecurringExpenses->PaidBy->find('list');
        $categories = $this->RecurringExpenses->ExpenseCategories->find('list')->where(['is_active' => true])->orderBy(['sort_order' => 'ASC']);
        $this->set(compact('recurringExpense', 'people', 'categories'));
        $this->render('add');
    }

    public function createExpense($id = null) {
        $this->request->allowMethod(['post']);

        $recurringExpense = $this->RecurringExpenses->get($id, contain: ['RecurringExpenseSplits']);

        try {
            $added = (new \App\Service\RecurringExpenseGenerator())->generate((int)$id, false);
            $this->Flash->success($added ? __('The expense has been added from the recurring expense.') : __('Already added this month.'));
        } catch (\Throwable $e) {
            $this->Flash->error(__('The expense could not be added. Please try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $recurringExpense = $this->RecurringExpenses->get($id);
        if ($this->RecurringExpenses->delete($recurringExpense)) {
            $this->Flash->success(__('The recurring expense has been deleted.'));
        } else {
            $this->Flash->error(__('The recurring expense could not be deleted. Please try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
