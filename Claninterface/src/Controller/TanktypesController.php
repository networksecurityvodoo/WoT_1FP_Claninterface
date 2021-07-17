<?php

namespace App\Controller;

use App\Controller\AppController;

/**
 * Tanktypes Controller
 *
 * @property \App\Model\Table\TanktypesTable $Tanktypes
 *
 * @method \App\Model\Entity\Tanktype[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TanktypesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $tanktypes = $this->paginate($this->Tanktypes);

        $this->set(compact('tanktypes'));
    }

    /**
     * View method
     *
     * @param string|null $id Tanktype id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tanktype = $this->Tanktypes->get($id, [
            'contain' => [],
        ]);

        $this->set('tanktype', $tanktype);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $tanktype = $this->Tanktypes->newEntity();
        if ($this->request->is('post')) {
            $tanktype = $this->Tanktypes->patchEntity($tanktype, $this->request->getData());
            if ($this->Tanktypes->save($tanktype)) {
                $this->Flash->success(__('The tanktype has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tanktype could not be saved. Please, try again.'));
        }
        $this->set(compact('tanktype'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Tanktype id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $tanktype = $this->Tanktypes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tanktype = $this->Tanktypes->patchEntity($tanktype, $this->request->getData());
            if ($this->Tanktypes->save($tanktype)) {
                $this->Flash->success(__('The tanktype has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tanktype could not be saved. Please, try again.'));
        }
        $this->set(compact('tanktype'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Tanktype id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tanktype = $this->Tanktypes->get($id);
        if ($this->Tanktypes->delete($tanktype)) {
            $this->Flash->success(__('The tanktype has been deleted.'));
        } else {
            $this->Flash->error(__('The tanktype could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function isAuthorized($user)
    {
        if ($this->permissionLevel >= 10) {
            return true;
        }
        return false;
    }

    public function initialize()
    {
        parent::initialize();
    }
}
