<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Meetingparticipants Controller
 *
 * @property \App\Model\Table\MeetingparticipantsTable $Meetingparticipants
 *
 * @method \App\Model\Entity\Meetingparticipant[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MeetingparticipantsController extends AppController
{    /**
     * Delete method
     *
     * @param string|null $id Meetingparticipant id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $meetingparticipant = $this->Meetingparticipants->get($id);
        if ($this->Meetingparticipants->delete($meetingparticipant)) {
            $this->Flash->success(__('The meetingparticipant has been deleted.'));
        } else {
            $this->Flash->error(__('The meetingparticipant could not be deleted. Please, try again.'));
        }

        return $this->redirect($this->referer());
    }
    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');
        $action = strtolower($action);

        $pl = $this->permissionLevel;

        if ($pl >= 8){
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
