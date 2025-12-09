<?php
declare(strict_types=1);

namespace App\Controller;

class PaymentsController extends AppController
{
    public function index()
    {
        $payments = $this->Payments->find('all')
            ->contain(['FromPerson', 'ToPerson'])
            ->order(['Payments.payment_date' => 'DESC']);
        
        $this->set(compact('payments'));
    }

    public function add()
    {
        $payment = $this->Payments->newEmptyEntity();
        if ($this->request->is('post')) {
            $payment = $this->Payments->patchEntity($payment, $this->request->getData());
            if ($this->Payments->save($payment)) {
                $this->Flash->success(__('Plačilo je bilo dodano.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Plačila ni bilo mogoče dodati. Prosim poskusite ponovno.'));
        }
        
        $people = $this->Payments->FromPerson->find('list');
        $this->set(compact('payment', 'people'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $payment = $this->Payments->get($id);
        if ($this->Payments->delete($payment)) {
            $this->Flash->success(__('Plačilo je bilo izbrisano.'));
        } else {
            $this->Flash->error(__('Plačila ni bilo mogoče izbrisati. Prosim poskusite ponovno.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}