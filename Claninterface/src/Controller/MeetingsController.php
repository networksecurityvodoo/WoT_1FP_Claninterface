<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Logic\Helper\MeetingsHelper;

/**
 * Meetings Controller
 *
 * @property \App\Model\Table\MeetingsTable $Meetings
 *
 * @method \App\Model\Entity\Meeting[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MeetingsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->set('meetings', $this->Meetings->find("all")->contain(["Clans"])->where(["date >=" => date("Y-m-d")]));
        $this->set('oldMeetings', $this->Meetings->find("all")->contain(["Clans"])->where(["date <" => date("Y-m-d")]));
        MeetingsHelper::findParticipant();
    }

    /**
     * View method
     *
     * @param string|null $id Meeting id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $meeting = $this->Meetings->get($id, [
            'contain' => ['Clans', 'Meetingparticipants','Meetingparticipants.Players','Meetingparticipants.Players.Ranks'],
        ]);

        $this->set('meeting', $meeting);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $meeting = $this->Meetings->newEntity();
        if ($this->request->is('post')) {
            $meeting = $this->Meetings->patchEntity($meeting, $this->request->getData());
            if ($this->Meetings->save($meeting)) {
                $this->Flash->success(__('The meeting has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The meeting could not be saved. Please, try again.'));
        }
        $clans = $this->Meetings->Clans->find('list', ['limit' => 200]);
        $this->set(compact('meeting', 'clans'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Meeting id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $meeting = $this->Meetings->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $meeting = $this->Meetings->patchEntity($meeting, $this->request->getData());
            if ($this->Meetings->save($meeting)) {
                $this->Flash->success(__('The meeting has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The meeting could not be saved. Please, try again.'));
        }
        $clans = $this->Meetings->Clans->find('list', ['limit' => 200]);
        $this->set(compact('meeting', 'clans'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Meeting id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $meeting = $this->Meetings->get($id);
        if ($this->Meetings->delete($meeting)) {
            $this->Flash->success(__('The meeting has been deleted.'));
        } else {
            $this->Flash->error(__('The meeting could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function isAuthorized($user)
    {

        if ($this->permissionLevel >= 8){
            return true;
        }

        return false;
    }

    public function initialize()
    {
        parent::initialize();
        // Add the 'add' action to the allowed actions list.
        $this->Auth->allow(['tsRank']);
    }
}
