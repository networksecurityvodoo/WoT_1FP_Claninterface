<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Logic\Helper\StringHelper;
use App\Logic\Helper\WN8Helper;
use App\Model\Entity\Tank;
use App\Model\Entity\User;
use Cake\Mailer\Email;
use Cake\ORM\TableRegistry;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Players'],
        ];
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Players'],
        ]);

        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData(), ['fields' => ['name', 'email', 'password']]);#

            //region Erster Benutzer wird Admin
            $regUsers = $this->Users->find("all")->count();
            if ($regUsers == 0) {
                $user->admin = 1;
            }
            //endregion

            if ($this->Users->save($user)) {
                $this->Flash->success(__('Der Benutzer wurde angelegt'));

                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error(__('Benutzer konnte nicht angelegt werden'));
        }

        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $players = $this->Users->Players->find('list', ['limit' => 200]);
        $this->set(compact('user', 'players'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function dashboard()
    {
        $UserIsAdmin = false;
        if ($this->Auth->user("admin")) {
            $UserIsAdmin = true;
        }

        $TokensTables = TableRegistry::getTableLocator()->get('Tokens');
        $token = $this->Users->Tokens->find("all")->contain(["players"])->where(['user_id' => $this->Auth->user("id"), 'Players.rank_id <=' => 2]);
        if ($token->count()) {
            $UserIsAdmin = true;
        }

        $players = $this->Users->Players->find("all");
        $players = $players
            ->select([
                "clanName" => "Clans.short",
                "Players.nick",
                "id" => "Players.id",
                "rank" => "Ranks.speekName",
                "rankIcon" => "Ranks.name",
                "expires" => "max(Tokens.expires)"
            ])
            ->innerJoinWith("tokens")
            ->innerJoinWith("Ranks")
            ->innerJoinWith("Clans")
            ->where([
                'Tokens.user_id' => $this->Auth->user("id"),
                "Tokens.expires >" => $players->func()->now()
            ])
            ->group("Players.id")
            ->orderAsc("rank_id")
            ->orderAsc("nick");

        $this->set("Players", $players);
        $this->set("UserIsAdmin", $UserIsAdmin);
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error('Your username or password is incorrect.');
        }

    }

    public function logout()
    {
        $this->Flash->success('You are now logged out.');
        return $this->redirect($this->Auth->logout());
    }

    public function newpass()
    {
        $id = $this->Auth->user('id');
        $user = $this->Users->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData(), [
                'fieldList' => [
                    'password_old',
                    'password',
                    'password_confirm',
                ]]);

            if ($this->Users->save($user)) {
                $this->Flash->success(__('Sie haben Ihr Passwort erfolgreich geändert.'));

                return $this->redirect(["controller" => "Users", "action" => "dashboard"]);
            }
            //  $this->Flash->error(__('The Password could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    public function unlock()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $accounts = $this->Users->find("all")->where(["email" => $this->request->getData("email")]);
            if ($accounts->count() >= 1) {
                /**
                 * @var User $account
                 */
                $account = $accounts->first();
                $newPassword = StringHelper::generateRandomString();
                $account->password = $newPassword;
                $this->Users->save($account);

                $title = "WoT-Claninterface Passwort vergessen";
                $email = new Email();
                $email->setEmailFormat('html');
                $email->viewBuilder()->setLayout('claninterface');
                $email->viewBuilder()->setTemplate('passwortReset');
                $email->setSubject($title);
                $email->setViewVars(['title' => $title]);
                $email->setViewVars(['newPassword' => $newPassword]);
                $email->setViewVars(['user' => $account]);
                $email->setTo($account->email, $account->name);
                if (!$email->send()) {
                    $this->Flash->error("Wir konnten keine E-Mail versenden.");
                }

            }
            $this->Flash->success("Wir haben Ihnen Ihr  neues Kennwort zugestellt");

        }
        $this->set("user", $user);
    }

    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');
        $action = strtolower($action);
        $user_id = $this->request->getParam('pass.0');
        $pl = $this->permissionLevel;

        if ($pl >= 0 && in_array($action, ["newpass", "dashboard"])) {
            return true;
        }
        if($user["id"] == $user_id && in_array($action,["view"])){
            return  true;
        }

        if ($pl >= 10) {
            return true;
        }
        return false;
    }

    public function initialize()
    {
        parent::initialize();
        // Add the 'add' action to the allowed actions list.
        $this->Auth->allow(['logout', 'add', 'unlock']);
    }
}
