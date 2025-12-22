<?php

declare(strict_types=1);

namespace App\Controller;

class PeopleController extends AppController {
    public function index() {
        $people = $this->People->find('all')->contain([
            'Expenses',
            'ExpenseSplits',
            'PaymentsFrom',
            'PaymentsTo'
        ]);

        $this->set(compact('people'));
    }

    public function view($id = null) {
        $person = $this->People->get($id, contain: [
            'Expenses',
            'ExpenseSplits.Expenses',
            'PaymentsFrom.ToPerson',
            'PaymentsTo.FromPerson'
        ]);

        $this->set(compact('person'));
    }

    public function add() {
        $person = $this->People->newEmptyEntity();
        if ($this->request->is('post')) {
            $person = $this->People->patchEntity($person, $this->request->getData());
            if ($this->People->save($person)) {
                $this->Flash->success(__('The person has been added.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The person could not be added. Please try again.'));
        }
        $this->set(compact('person'));
    }

    public function edit($id = null) {
        $person = $this->People->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $person = $this->People->patchEntity($person, $this->request->getData());
            if ($this->People->save($person)) {
                $this->Flash->success(__('The person has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The person could not be updated. Please try again.'));
        }
        $this->set(compact('person'));
    }

    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $person = $this->People->get($id);
        if ($this->People->delete($person)) {
            $this->Flash->success(__('The person has been deleted.'));
        } else {
            $this->Flash->error(__('The person could not be deleted. Please try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
