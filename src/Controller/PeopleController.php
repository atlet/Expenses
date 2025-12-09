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
                $this->Flash->success(__('Oseba je bila dodana.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Osebe ni bilo mogoče dodati. Prosim poskusite ponovno.'));
        }
        $this->set(compact('person'));
    }

    public function edit($id = null) {
        $person = $this->People->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $person = $this->People->patchEntity($person, $this->request->getData());
            if ($this->People->save($person)) {
                $this->Flash->success(__('Oseba je bila posodobljena.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Osebe ni bilo mogoče posodobiti. Prosim poskusite ponovno.'));
        }
        $this->set(compact('person'));
    }

    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $person = $this->People->get($id);
        if ($this->People->delete($person)) {
            $this->Flash->success(__('Oseba je bila izbrisana.'));
        } else {
            $this->Flash->error(__('Osebe ni bilo mogoče izbrisati. Prosim poskusite ponovno.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
