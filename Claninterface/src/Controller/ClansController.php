<?php
namespace App\Controller;



use App\Logic\Helper\WarGamingHelper;

/**
 * Clans Controller
 *
 * @property \App\Model\Table\ClansTable $Clans
 *
 * @method \App\Model\Entity\Clan[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ClansController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $clans = $this->Clans->find("all")->orderDesc("cron")->orderAsc("short");

        $this->set(compact('clans'));
    }

    /**
     * View method
     *
     * @param string|null $id Clan id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $clan = $this->Clans->get($id, [
            'contain' => ['Players','Players.Ranks'],
        ]);

        $this->set('clan', $clan);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $clan = $this->Clans->newEntity();
        if ($this->request->is('post')) {
            $clan = $this->Clans->patchEntity($clan, $this->request->getData(),['fields' => ['short']]);
            $WgApi = new WarGamingHelper();
            $clan = $WgApi->searchClanInfo($clan);
            if($clan) {
                if ($this->Clans->save($clan)) {
                    $this->Flash->success(__('Der Clan wurde in das Interface aufgenommen.'));
                    return $this->redirect(['action' => 'index']);
                }

                $this->Flash->error(__('Die Clandaten konnten nicht gespeichert werden'));
            }else{
                $this->Flash->error(__('Die Clandaten konnten nicht von Wargaming abgerufen werden.'));
            }
        }
        $this->set(compact('clan'));
    }
    /**
     * Pulls all Infos from WG API
     *
     * @param string|null $id Clan id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function renew($id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $clan = $this->Clans->get($id);
        $WgApi = new WarGamingHelper();
        $clan = $WgApi->getClanInfo($clan);
        if($clan) {
            if ($this->Clans->save($clan)) {
                $this->Flash->success(__('Die Clandaten wurden erfolgreich erneuert.'));
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('Die Clandaten konnten nicht gespeichert werden'));
        }else{
            $this->Flash->error(__('Die Clandaten konnten nicht von Wargaming abgerufen werden.'));
        }
    }

    public function getClanMembers($id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $clan = $this->Clans->get($id);
        $WgApi = new WarGamingHelper();
        $data = $WgApi->updateClanMembers($clan->id);
        if($data !== false){
            $this->Flash->success("Es wurde $data Mitglieder für [{$clan->short}] gefunden");
        }else{
            $this->Flash->error(__('Die Clandaten konnten nicht von Wargaming abgerufen werden.'));
        }
        return $this->redirect(['action' => 'index']);

    }
    public function toggle($id){
        $this->request->allowMethod(['post']);
        $clan = $this->Clans->get($id);
        $clan->cron = $clan->cron?0:1;
        $this->Clans->save($clan);
        $this->Flash->success("Clan Aktivierung wurde umgeschalten");
        return $this->redirect($this->referer());
    }


    /**
     * Delete method
     *
     * @param string|null $id Clan id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $clan = $this->Clans->get($id);
        if ($this->Clans->delete($clan)) {
            $this->Flash->success(__('The clan has been deleted.'));
        } else {
            $this->Flash->error(__('The clan could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');
        $action = strtolower($action);
        $pl = $this->permissionLevel;

        if ($pl >= 5 && in_array($action, ["view","index"])){
            return true;
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
        $this->Auth->allow(['tsRank']);
    }
}
