<?php

declare(strict_types=1);

namespace App\Controller;

class UsersController extends AppController {
    public function beforeFilter(\Cake\Event\EventInterface $event) {
        parent::beforeFilter($event);

        // Allow unauthenticated access to login action
        $this->Authentication->addUnauthenticatedActions(['login']);
    }

    public function login() {
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();

        // If user is already logged in, redirect
        if ($result && $result->isValid()) {
            // Update last login
            $user = $this->Authentication->getIdentity();
            $userEntity = $this->Users->get($user->getIdentifier());
            $userEntity->last_login = new \DateTime();
            $this->Users->save($userEntity);

            // Redirect to dashboard
            $redirect = $this->request->getQuery('redirect', [
                'controller' => 'Dashboard',
                'action' => 'index',
            ]);

            return $this->redirect($redirect);
        }

        // Display error if user submitted invalid credentials
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error(__('Invalid username or password'));
        }
    }

    public function logout() {
        $result = $this->Authentication->getResult();

        if ($result && $result->isValid()) {
            $this->Authentication->logout();
            $this->Flash->success(__('You have been logged out.'));
        }

        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }

    public function index() {
        // Only admins can view user list
        $this->checkAdminAccess();

        $users = $this->Users->find('all')->order(['Users.username' => 'ASC']);
        $this->set(compact('users'));
    }

    public function add() {
        // Only admins can add users
        $this->checkAdminAccess();

        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been created.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please try again.'));
        }
        $this->set(compact('user'));
    }

    public function edit($id = null) {
        // Only admins can edit users
        $this->checkAdminAccess();

        $user = $this->Users->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be updated. Please try again.'));
        }
        $this->set(compact('user'));
    }

    public function delete($id = null) {
        // Only admins can delete users
        $this->checkAdminAccess();

        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);

        // Prevent deleting yourself
        $currentUser = $this->Authentication->getIdentity();
        if ($currentUser->getIdentifier() == $id) {
            $this->Flash->error(__('You cannot delete your own account.'));
            return $this->redirect(['action' => 'index']);
        }

        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function profile() {
        $user = $this->Users->get($this->Authentication->getIdentity()->getIdentifier());

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            // Remove password if empty
            if (empty($data['password'])) {
                unset($data['password']);
            }

            $user = $this->Users->patchEntity($user, $data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Your profile has been updated.'));
                return $this->redirect(['action' => 'profile']);
            }
            $this->Flash->error(__('Your profile could not be updated. Please try again.'));
        }

        $this->set(compact('user'));
    }

    private function checkAdminAccess() {
        $user = $this->Authentication->getIdentity();
        if (!$user || $user->role !== 'admin') {
            $this->Flash->error(__('You do not have permission to access this page.'));
            $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
        }
    }
}
