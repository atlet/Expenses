<?php

declare(strict_types=1);

namespace App\Controller;

class ExpenseCategoriesController extends AppController {
    public function index() {
        $categories = $this->ExpenseCategories->find('all')
            ->order(['ExpenseCategories.sort_order' => 'ASC', 'ExpenseCategories.name' => 'ASC']);

        $this->set(compact('categories'));
    }

    public function add() {
        $category = $this->ExpenseCategories->newEmptyEntity();
        if ($this->request->is('post')) {
            $category = $this->ExpenseCategories->patchEntity($category, $this->request->getData());
            if ($this->ExpenseCategories->save($category)) {
                $this->Flash->success(__('The category has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The category could not be saved. Please try again.'));
        }
        $this->set(compact('category'));
    }

    public function edit($id = null) {
        $category = $this->ExpenseCategories->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $category = $this->ExpenseCategories->patchEntity($category, $this->request->getData());
            if ($this->ExpenseCategories->save($category)) {
                $this->Flash->success(__('The category has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The category could not be updated. Please try again.'));
        }
        $this->set(compact('category'));
    }

    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $category = $this->ExpenseCategories->get($id);
        if ($this->ExpenseCategories->delete($category)) {
            $this->Flash->success(__('The category has been deleted.'));
        } else {
            $this->Flash->error(__('The category could not be deleted. Please try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
