<?php

declare(strict_types=1);

namespace App\Controller;

class SuppliersController extends AppController {
    public function index() {
        $suppliers = $this->Suppliers->find('all')
            ->where(['is_active' => true])
            ->order(['Suppliers.name' => 'ASC']);

        $this->set(compact('suppliers'));
    }

    public function add() {
        $supplier = $this->Suppliers->newEmptyEntity();
        if ($this->request->is('post')) {
            $supplier = $this->Suppliers->patchEntity($supplier, $this->request->getData());
            if ($this->Suppliers->save($supplier)) {
                $this->Flash->success(__('The supplier has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The supplier could not be saved. Please try again.'));
        }
        $this->set(compact('supplier'));
    }

    public function edit($id = null) {
        $supplier = $this->Suppliers->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $supplier = $this->Suppliers->patchEntity($supplier, $this->request->getData());
            if ($this->Suppliers->save($supplier)) {
                $this->Flash->success(__('The supplier has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The supplier could not be updated. Please try again.'));
        }
        $this->set(compact('supplier'));
    }

    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $supplier = $this->Suppliers->get($id);
        if ($this->Suppliers->delete($supplier)) {
            $this->Flash->success(__('The supplier has been deleted.'));
        } else {
            $this->Flash->error(__('The supplier could not be deleted. Please try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
