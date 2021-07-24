<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Logic\Helper\StringHelper;

/**
 * Tokens Controller
 *
 * @property \App\Model\Table\TokensTable $Tokens
 *
 * @method \App\Model\Entity\Token[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TokensController extends AppController
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
        $tokens = $this->paginate($this->Tokens);

        $this->set(compact('tokens'));
    }

    /**
     * View method
     *
     * @param string|null $id Token id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $token = $this->Tokens->get($id, [
            'contain' => ['Players'],
        ]);

        $this->set('token', $token);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $token = $this->Tokens->newEntity();
        if ($this->request->is('post')) {
            $token = $this->Tokens->patchEntity($token, $this->request->getData());
            if ($this->Tokens->save($token)) {
                $this->Flash->success(__('The token has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The token could not be saved. Please, try again.'));
        }
        $players = $this->Tokens->Players->find('list', ['limit' => 200]);
        $this->set(compact('token', 'players'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Token id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $token = $this->Tokens->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $token = $this->Tokens->patchEntity($token, $this->request->getData());
            if ($this->Tokens->save($token)) {
                $this->Flash->success(__('The token has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The token could not be saved. Please, try again.'));
        }
        $players = $this->Tokens->Players->find('list', ['limit' => 200]);
        $this->set(compact('token', 'players'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Token id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $token = $this->Tokens->get($id);
        if ($this->Tokens->delete($token)) {
            $this->Flash->success(__('The token has been deleted.'));
        } else {
            $this->Flash->error(__('The token could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Nimmt Token von WG entgegen
     * @return \Cake\Http\Response|null
     */
    public function receive(): ?\Cake\Http\Response
    {
        $data = $this->request->getParam('?');
        if($data["status"] != "error"){

            // var_dump($data);
            $token = $this->Tokens->newEntity();
            $token->player_id = $data["account_id"];
            $token->nickname = $data["nickname"];
            $token->token = $data["access_token"];
            $token->expires = \DateTime::createFromFormat('U', $data["expires_at"]);
            $token->user_id = $this->Auth->user('id');
            $saved = $this->Tokens->save($token);
            if ($saved) {
                $this->Flash->success("Wir haben den Token gespeichert.");
            } else {
                $this->Flash->error("Leider gabe es einen Fehler");
            }
        }else {
            $this->Flash->error("Es gab einen Fehler bei der Anmeldung");
        }
        return $this->redirect(['controller' => 'Users', 'action' => 'Dashboard']);
    }
    public function login()
    {
        $data = $this->request->getParam('?');

        if($data["status"] != "error"){


            //TODO: Entscheidung ob man hier eine richtige E-Mail haben sollte
            $email = "wg".$data["account_id"].$data["account_id"];

            $user = null;
            $users = $this->Tokens->Users->find("all")->where(["email"=>$email]);
            if($users->count()){
                $user = $users->first();
            }else {
                $user = $this->Tokens->Users->newEntity();
                $user->name = "WG_" . $data["nickname"];
                $user->email = $email;
                $user->password = StringHelper::generateRandomString(32);
                $user->admin = 0;
                $user->player_id = $data["account_id"];
                $this->Tokens->Users->save($user);
            }

            $token = $this->Tokens->newEntity();
            $token->player_id = $data["account_id"];
            $token->nickname = $data["nickname"];
            $token->token = $data["access_token"];
            $token->expires = \DateTime::createFromFormat('U', $data["expires_at"]);
            $token->user_id = $user->id;
            $saved = $this->Tokens->save($token);
            if ($saved) {
                $this->Auth->setUser($user);
                $this->Flash->success("Wir haben den Token gespeichert.");
                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Flash->error("Leider gabe es einen Fehler");
            }
        }else {
            $this->Flash->error("Es gab einen Fehler bei der Anmeldung");
        }
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }


    public function isAuthorized($user)
    {
        if (in_array($this->request->getParam('action'), ['receive'])) {
            return true;
        }

        if ($this->permissionLevel >= 10) {
            return true;
        }
        return false;
    }
    public function initialize()
    {
        parent::initialize();
        // Add the 'add' action to the allowed actions list.
        $this->Auth->allow(['login']);
    }
}
