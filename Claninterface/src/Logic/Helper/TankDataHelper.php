<?php


namespace App\Logic\Helper;


use App\Logic\Config\WgApi;
use App\Model\Entity\Tank;
use App\Model\Entity\Tanktype;
use App\Model\Table\TanksTable;
use App\Model\Table\TanktypesTable;
use Cake\Core\Configure;
use Cake\Datasource\Exception\InvalidPrimaryKeyException;
use Cake\ORM\TableRegistry;

class TankDataHelper
{
    private $api = null;
    private $wn8expectedValues =null;
    private $tanktypes = null;

    public function __construct()
    {
        $this->api =  WgApi::getWG_API();

    }



    public function getTankList($id = null){
        $tankList= null;
        if(!$id) {
            $tankList = $this->api->get("wot/encyclopedia/vehicles", ["fields" => "tank_id,tier,name,type,nation,description,is_premium"]);
        }else{
            $tankList = $this->api->get("wot/encyclopedia/vehicles", ["fields" => "tank_id,tier,name,type,nation,description,is_premium", "tank_id"=>$id]);
        }
        return $tankList;
    }
    public function importTank($WGData, $fullimport = false)
    {
        $TanksTable = TableRegistry::getTableLocator()->get('Tanks');

        if ($fullimport) {
        $TanksTable->deleteAll([]);
        }

        $i = 0;
        foreach ($WGData as $data){
            /** @var TanksTable $dbData */
            if(!$fullimport) {
                try {
                    $tank = $TanksTable->get($data->tank_id);
                } catch (\Exception $exception) {
                    $tank = $TanksTable->newEntity();
                    $tank->id = $data->tank_id;
                }
            }else{
                $tank = $TanksTable->newEntity();
                $tank->id = $data->tank_id;
            }
            $tank->name = $data->name;
            $tank->tier = $data->tier;
            $tank->nation = $data->nation;
            $tank->premium = $data->is_premium?1:0;
            $tank->tankType_id = $this->getTanksType($data->type);

            $tank = $this->fillExpectedValues($tank);
            $TanksTable->save($tank);
            $i++;
        }
        return $i;
    }

    private function getTanksType($searchedType){
        if($this->tanktypes == null) {
            $this->tanktypes = array();
            /** @var TanktypesTable $TypesTable */
            $TypesTable = TableRegistry::getTableLocator()->get('Tanktypes');
            $types = $TypesTable->find("all");
            /** @var Tanktype $type */
            foreach ($types as $type) {
                $this->tanktypes[$type->name] = $type->id;
            }
        }
        if(isset($this->tanktypes[$searchedType])){
            return $this->tanktypes[$searchedType];
        }
        else{

            //ADD Missing Type
            /** @var TanktypesTable $TypesTable */
            $TypesTable = TableRegistry::getTableLocator()->get('Tanktypes');
            $type = $TypesTable->newEntity();
            $type->name =$searchedType;
            $TypesTable->save($type);

            //add to Cache
            $this->tanktypes[$type->name] = $type->id;

            return $type->id;


        }
}

    private function modXVMgetExpectedValues(){
            $json = file_get_contents(Configure::read('Wargaming.expectedValues'));
            $this->wn8expectedValues = json_decode($json,true)["data"];
    }

    /**
     * @param Tank $tank
     */
    private function fillExpectedValues($tank)
    {
        if($this->wn8expectedValues == null) {
            $this->modXVMgetExpectedValues();
        }
        foreach ($this->wn8expectedValues as $expectedValue) {
            if($expectedValue["IDNum"] == $tank->id) {

                $tank->expDef = $expectedValue["expDef"];
                $tank->expFrag = $expectedValue["expFrag"];
                $tank->expSpot = $expectedValue["expSpot"];
                $tank->expDamage = $expectedValue["expDamage"];
                $tank->expWinRate = $expectedValue["expWinRate"];

                return $tank;
            }
        }
        return $tank;

    }







}
