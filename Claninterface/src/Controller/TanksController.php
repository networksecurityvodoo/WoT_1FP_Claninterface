<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Logic\Config\StatisticsConfigHelper;
use App\Logic\Helper\TankDataHelper;

/**
 * Tanks Controller
 *
 * @property \App\Model\Table\TanksTable $Tanks
 *
 * @method \App\Model\Entity\Tank[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TanksController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $tanks = $this->Tanks->find("all")->contain("Tanktypes")->where(["expDamage >" => 0]);

        $this->set(compact('tanks'));
    }

    /**
     * View method
     *
     * @param string|null $id Tank id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id,$battletype = false)
    {

        if($battletype == false){
            $battletype = StatisticsConfigHelper::$BattleTypes[0];
        }
        $tank = $this->Tanks->get($id, [
            'contain' => ['Tanktypes'],
        ]);

        $newestData = $this->Tanks->Statistics->find("all")->orderDesc("date")->first();
        $newestData = $newestData->date;

        $stats = $this->Tanks->Statistics->find("all")->contain(["Players","Players.Clans","Tanks"])->innerJoinWith("Players.Clans");
        $stats->where(["battletype"=>$battletype,"date"=>$newestData, "tank_id"=>$id]);


        $this->set('stats', $stats);
        $this->set('tank', $tank);
        $this->set("battletype",$battletype);
    }


    public function import(){
        $TankHelper = new TankDataHelper();
        $TankListr=  $TankHelper->getTankList();
        $TankHelper->importTank($TankListr,true);
        return $this->redirect($this->referer());
    }
    public function isAuthorized($user)
    {
        if ($this->permissionLevel >= 5) {
            return true;
        }
        return false;
    }

    public function initialize()
    {
        parent::initialize();
    }
}
