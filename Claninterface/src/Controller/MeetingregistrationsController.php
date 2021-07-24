<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Meetingregistrations Controller
 *
 * @property \App\Model\Table\MeetingregistrationsTable $Meetingregistrations
 *
 * @method \App\Model\Entity\Meetingregistration[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MeetingregistrationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Players', 'Meetings'],
        ];
        $meetingregistrations = $this->paginate($this->Meetingregistrations);

        $this->set(compact('meetingregistrations'));
    }

    /**
     * View method
     *
     * @param string|null $id Meetingregistration id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $meetingregistration = $this->Meetingregistrations->get($id, [
            'contain' => ['Players', 'Meetings'],
        ]);

        $this->set('meetingregistration', $meetingregistration);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $meetingregistration = $this->Meetingregistrations->newEntity();
        if ($this->request->is('post')) {
            $meetingregistration = $this->Meetingregistrations->patchEntity($meetingregistration, $this->request->getData());
            if ($this->Meetingregistrations->save($meetingregistration)) {
                $this->Flash->success(__('The meetingregistration has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The meetingregistration could not be saved. Please, try again.'));
        }
        $players = $this->Meetingregistrations->Players->find('list', ['limit' => 200]);
        $meetings = $this->Meetingregistrations->Meetings->find('list', ['limit' => 200]);
        $this->set(compact('meetingregistration', 'players', 'meetings'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Meetingregistration id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $meetingregistration = $this->Meetingregistrations->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $meetingregistration = $this->Meetingregistrations->patchEntity($meetingregistration, $this->request->getData());
            if ($this->Meetingregistrations->save($meetingregistration)) {
                $this->Flash->success(__('The meetingregistration has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The meetingregistration could not be saved. Please, try again.'));
        }
        $players = $this->Meetingregistrations->Players->find('list', ['limit' => 200]);
        $meetings = $this->Meetingregistrations->Meetings->find('list', ['limit' => 200]);
        $this->set(compact('meetingregistration', 'players', 'meetings'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Meetingregistration id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $meetingregistration = $this->Meetingregistrations->get($id);
        if ($this->Meetingregistrations->delete($meetingregistration)) {
            $this->Flash->success(__('The meetingregistration has been deleted.'));
        } else {
            $this->Flash->error(__('The meetingregistration could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
