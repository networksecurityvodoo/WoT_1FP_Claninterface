<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Form\InactivesForm;
use App\Logic\Helper\WarGamingHelper;
use Cake\Database\Expression\QueryExpression;
use Cake\ORM\Query;

/**
 * Inactives Controller
 *
 * @property \App\Model\Table\InactivesTable $Inactives
 *
 * @method \App\Model\Entity\Inactive[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class InactivesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->set('inactives',$this->Inactives->find("all")->contain(["Players","Players.Clans"])->innerJoinWith("Players.Clans"));
    }

    /**
     * View method
     *
     * @param string|null $id Inactive id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $inactive = $this->Inactives->get($id, [
            'contain' => ['Players'],
        ]);

        $this->set('inactive', $inactive);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $inactivesForm = new InactivesForm();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            $player = $this->Inactives->Players->find("all")->where(["nick"=>$data['player']])->first();

           if($player != null) {
               $inactive = $this->Inactives->newEntity();
               $inactive->player_id = $player->id;
               $inactive->battle = (new WarGamingHelper)->getBattleCount($player->id);
               $inactive->reason = $data['reason'];
               $inactive->offline = date("Y-m-d", strtotime($data['offline']));

               if($data["unkown"] == 1){
                    $inactive->offline = date("Y-m-d", 1);
               }


               if ($this->Inactives->save($inactive)) {
                   $this->Flash->success(__('Wir haben die Abmeldungen entgegen genommen.'));

                   return $this->redirect("/");
               }
           }
           if($player != null) {
               $this->Flash->error(__('Die Abmeldung konnten nicht gespeichert werden.'));
           }else{
               $this->Flash->error(__('Leider haben wir deinen Benutzernamen nicht gefunden.'));
           }
        }
        $this->set("inactivesForm",$inactivesForm);

        $players = $this->Inactives->Players->find("all");
        $players->where(function(QueryExpression $exp, Query $q) {
            return $exp->isNotNull('clan_id');
        });
        $js_player_array = "[";
        foreach ($players as $player){
            $js_player_array .= "'{$player->nick}',";
        }
        $js_player_array .= "]";
        $this->set("js_player_array",$js_player_array);
    }

    /**
     * Edit method
     *
     * @param string|null $id Inactive id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $inactive = $this->Inactives->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $inactive = $this->Inactives->patchEntity($inactive, $this->request->getData());
            if ($this->Inactives->save($inactive)) {
                $this->Flash->success(__('The inactive has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The inactive could not be saved. Please, try again.'));
        }
        $players = $this->Inactives->Players->find('list', ['limit' => 200]);
        $this->set(compact('inactive', 'players'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Inactive id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $inactive = $this->Inactives->get($id);
        if ($this->Inactives->delete($inactive)) {
            $this->Flash->success(__('The inactive has been deleted.'));
        } else {
            $this->Flash->error(__('The inactive could not be deleted. Please, try again.'));
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
        $this->Auth->allow(['add']);
    }
}
