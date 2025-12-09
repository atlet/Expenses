<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * RecurringExpenseSplits Controller
 *
 * @property \App\Model\Table\RecurringExpenseSplitsTable $RecurringExpenseSplits
 */
class RecurringExpenseSplitsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->RecurringExpenseSplits->find()
            ->contain(['RecurringExpenses', 'People']);
        $recurringExpenseSplits = $this->paginate($query);

        $this->set(compact('recurringExpenseSplits'));
    }

    /**
     * View method
     *
     * @param string|null $id Recurring Expense Split id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $recurringExpenseSplit = $this->RecurringExpenseSplits->get($id, contain: ['RecurringExpenses', 'People']);
        $this->set(compact('recurringExpenseSplit'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $recurringExpenseSplit = $this->RecurringExpenseSplits->newEmptyEntity();
        if ($this->request->is('post')) {
            $recurringExpenseSplit = $this->RecurringExpenseSplits->patchEntity($recurringExpenseSplit, $this->request->getData());
            if ($this->RecurringExpenseSplits->save($recurringExpenseSplit)) {
                $this->Flash->success(__('The recurring expense split has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The recurring expense split could not be saved. Please, try again.'));
        }
        $recurringExpenses = $this->RecurringExpenseSplits->RecurringExpenses->find('list', limit: 200)->all();
        $people = $this->RecurringExpenseSplits->People->find('list', limit: 200)->all();
        $this->set(compact('recurringExpenseSplit', 'recurringExpenses', 'people'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Recurring Expense Split id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $recurringExpenseSplit = $this->RecurringExpenseSplits->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $recurringExpenseSplit = $this->RecurringExpenseSplits->patchEntity($recurringExpenseSplit, $this->request->getData());
            if ($this->RecurringExpenseSplits->save($recurringExpenseSplit)) {
                $this->Flash->success(__('The recurring expense split has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The recurring expense split could not be saved. Please, try again.'));
        }
        $recurringExpenses = $this->RecurringExpenseSplits->RecurringExpenses->find('list', limit: 200)->all();
        $people = $this->RecurringExpenseSplits->People->find('list', limit: 200)->all();
        $this->set(compact('recurringExpenseSplit', 'recurringExpenses', 'people'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Recurring Expense Split id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $recurringExpenseSplit = $this->RecurringExpenseSplits->get($id);
        if ($this->RecurringExpenseSplits->delete($recurringExpenseSplit)) {
            $this->Flash->success(__('The recurring expense split has been deleted.'));
        } else {
            $this->Flash->error(__('The recurring expense split could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
