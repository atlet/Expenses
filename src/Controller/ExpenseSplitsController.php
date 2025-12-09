<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ExpenseSplits Controller
 *
 * @property \App\Model\Table\ExpenseSplitsTable $ExpenseSplits
 */
class ExpenseSplitsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->ExpenseSplits->find()
            ->contain(['Expenses', 'People']);
        $expenseSplits = $this->paginate($query);

        $this->set(compact('expenseSplits'));
    }

    /**
     * View method
     *
     * @param string|null $id Expense Split id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $expenseSplit = $this->ExpenseSplits->get($id, contain: ['Expenses', 'People']);
        $this->set(compact('expenseSplit'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $expenseSplit = $this->ExpenseSplits->newEmptyEntity();
        if ($this->request->is('post')) {
            $expenseSplit = $this->ExpenseSplits->patchEntity($expenseSplit, $this->request->getData());
            if ($this->ExpenseSplits->save($expenseSplit)) {
                $this->Flash->success(__('The expense split has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The expense split could not be saved. Please, try again.'));
        }
        $expenses = $this->ExpenseSplits->Expenses->find('list', limit: 200)->all();
        $people = $this->ExpenseSplits->People->find('list', limit: 200)->all();
        $this->set(compact('expenseSplit', 'expenses', 'people'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Expense Split id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $expenseSplit = $this->ExpenseSplits->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $expenseSplit = $this->ExpenseSplits->patchEntity($expenseSplit, $this->request->getData());
            if ($this->ExpenseSplits->save($expenseSplit)) {
                $this->Flash->success(__('The expense split has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The expense split could not be saved. Please, try again.'));
        }
        $expenses = $this->ExpenseSplits->Expenses->find('list', limit: 200)->all();
        $people = $this->ExpenseSplits->People->find('list', limit: 200)->all();
        $this->set(compact('expenseSplit', 'expenses', 'people'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Expense Split id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $expenseSplit = $this->ExpenseSplits->get($id);
        if ($this->ExpenseSplits->delete($expenseSplit)) {
            $this->Flash->success(__('The expense split has been deleted.'));
        } else {
            $this->Flash->error(__('The expense split could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
