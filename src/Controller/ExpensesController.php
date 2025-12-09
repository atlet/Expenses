<?php

declare(strict_types=1);

namespace App\Controller;

class ExpensesController extends AppController {
    public function index() {
        $expenses = $this->Expenses->find('all')
            ->contain(['PaidBy', 'ExpenseSplits.People'])
            ->order(['Expenses.expense_date' => 'DESC']);

        $this->set(compact('expenses'));
    }

    public function view($id = null) {
        $expense = $this->Expenses->get($id, contain: [
            'PaidBy',
            'ExpenseSplits.People'
        ]);

        $this->set(compact('expense'));
    }

    public function add() {
        $expense = $this->Expenses->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();

            // Izračunaj delež za vsako osebo
            $splitPeople = $data['split_people'] ?? [];
            $shareRatio = count($splitPeople) > 0 ? 1 / count($splitPeople) : 0;

            // Pripravi expense splits
            $expenseSplits = [];
            foreach ($splitPeople as $personId) {
                $expenseSplits[] = [
                    'person_id' => $personId,
                    'share_ratio' => $shareRatio
                ];
            }
            $data['expense_splits'] = $expenseSplits;

            $expense = $this->Expenses->patchEntity($expense, $data, [
                'associated' => ['ExpenseSplits']
            ]);

            if ($this->Expenses->save($expense)) {
                $this->Flash->success(__('Strošek je bil dodan.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Stroška ni bilo mogoče dodati. Prosim poskusite ponovno.'));
        }

        $people = $this->Expenses->PaidBy->find('list');
        $this->set(compact('expense', 'people'));
    }

    public function edit($id = null) {
        $expense = $this->Expenses->get($id, contain: ['ExpenseSplits']);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            // Izbriši stare splits
            $this->Expenses->ExpenseSplits->deleteAll(['expense_id' => $id]);

            // Dodaj nove splits
            $splitPeople = $data['split_people'] ?? [];
            $shareRatio = count($splitPeople) > 0 ? 1 / count($splitPeople) : 0;

            $expenseSplits = [];
            foreach ($splitPeople as $personId) {
                $expenseSplits[] = [
                    'person_id' => $personId,
                    'share_ratio' => $shareRatio
                ];
            }
            $data['expense_splits'] = $expenseSplits;

            $expense = $this->Expenses->patchEntity($expense, $data, [
                'associated' => ['ExpenseSplits']
            ]);

            if ($this->Expenses->save($expense)) {
                $this->Flash->success(__('Strošek je bil posodobljen.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Stroška ni bilo mogoče posodobiti. Prosim poskusite ponovno.'));
        }

        $people = $this->Expenses->PaidBy->find('list');
        $selectedPeople = [];
        foreach ($expense->expense_splits as $split) {
            $selectedPeople[] = $split->person_id;
        }

        $this->set(compact('expense', 'people', 'selectedPeople'));
    }

    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $expense = $this->Expenses->get($id);
        if ($this->Expenses->delete($expense)) {
            $this->Flash->success(__('Strošek je bil izbrisan.'));
        } else {
            $this->Flash->error(__('Stroška ni bilo mogoče izbrisati. Prosim poskusite ponovno.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
