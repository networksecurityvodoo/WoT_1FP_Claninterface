<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Logic\Config\StatisticsConfigHelper;
use App\Logic\Config\WgApi;
use App\Logic\Helper\PlayerDataHelper;
use App\Logic\Helper\RanksHelper;
use App\Logic\Helper\WarGamingHelper;
use App\Model\Entity\Clan;
use App\Model\Entity\Player;
use Cake\Database\Expression\QueryExpression;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;

/**
 * Players Controller
 *
 * @property \App\Model\Table\PlayersTable $Players
 *
 * @method \App\Model\Entity\Player[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PlayersController extends AppController
{


    /**
     * View method
     *
     * @param string $id Player id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id, $battletype = false)
    {

        if($battletype == false){
            $battletype = StatisticsConfigHelper::$BattleTypes[0];
        }

        $player = $this->Players->get($id, [
            'contain' => ['Clans', 'Ranks', "Meetingparticipants", "Meetingparticipants.Meetings"],
        ]);

        $newestData = $this->Players->Statistics->find("all")->orderDesc("date")->first();
        $newestData = $newestData->date;

        $stats = $this->Players->Statistics->find("all")->contain(["Players", "Players.Clans", "Tanks", "Tanks.Tanktypes"]);
        $stats->where(["battletype" => "$battletype", "date" => $newestData, "player_id" => $id]);
        $this->set('stats', $stats);
        $this->set('player', $player);
        $this->set("battletype",$battletype);

    }

    public function importStatistic($clan)
    {
        $PlayerHelper = new PlayerDataHelper();
        $c = $PlayerHelper->importPlayerStatistic($clan);
        $this->Flash->success("Es wurden $c Datensätze geladen.");
        return $this->redirect($this->referer());
    }
    public function tankStats($player, $tank,$battletype = false)
    {

        if($battletype == false){
            $battletype = StatisticsConfigHelper::$BattleTypes[0];
        }
        $this->set("Player",$this->Players->get($player));
        $this->set("stats", $this->Players->Statistics->find("all")->contain(["Tanks"])->where(["player_id" => $player,"tank_id"=>$tank,"battletype"=>"$battletype"])->orderDesc("date")->limit(100)->toArray());
        $this->set("battletype",$battletype);
    }
    public function tsRank()
    {
        //<editor-fold desc="Spieler">
        $players = $this->Players->find("all");
        $players->where(function (QueryExpression $exp, Query $q) {
            return $exp->isNotNull('clan_id');
        });
        $js_player_array = "[";
        foreach ($players as $player) {
            $js_player_array .= "'{$player->nick}',";
        }
        $js_player_array .= "]";
        $this->set("js_player_array", $js_player_array);
        //</editor-fold>

        $this->set("form", $this->Players->newEntity());
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            /**
             * @var Player $player
             */
            $player = $this->Players->find("all")->where(["nick" => $data['player']])->contain(["Clans", "Ranks"])->first();
            if ($player != null) {

                $wgHelper = new WarGamingHelper();
                $days = $wgHelper->getOldDays($player->id, $player->joined);
                $this->set("rank", RanksHelper::days2rank($days));
                $this->set("days", $days);
                $this->set("player", $player);
            }
        }

    }
    public function tree(){
        $wgh = new WarGamingHelper();
        $players = $this->Players->find("all")->contain(["Clans"]);

        $i = 0;
        $j = 0;
        $data = array();
        /** @var Player $player */
        foreach ($players as $player){
            if($j == 0){
                $data[$i] ="";
            }
           $data[$i] .= $player->id.",";
           $j++;
           if($j >= 100){
               $i++; $j=0;
           }
        }
        $score = array();

        foreach ($data as $set){
            $wgh->getPlayersInfos($set);
            $res = $wgh->getAccountsInfo();
            foreach ($res as $p =>$d){
                $tree =$d->statistics->trees_cut / $d->statistics->all->battles;
                $score [] = array($tree, $d->nickname);
            }

        }
        $price = array_column($score, 0);
        array_multisort($price, SORT_DESC, $score);
        foreach ($score as $s){
            echo round($s[0],4)." - ".$s[1]."<br />";
        }

    }

    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');
        $action = strtolower($action);
        $pl = $this->permissionLevel;

        if ($pl >= 0 && in_array($action, ["newpass", "dashboard"])) {
            return true;
        }


        $PlayersTables = TableRegistry::getTableLocator()->get('Players');
        $players = $PlayersTables->find("all");
        $players = $players
            ->select([
                "id" => "Players.id",
            ])
            ->innerJoinWith("tokens")
            ->innerJoinWith("Clans")
            ->where([
                'Tokens.user_id' => $user["id"],
                "Tokens.expires >" => $players->func()->now()
            ]);
        foreach ($players as $player){
            if ($player->id ==  $this->request->getParam('pass.0')) {
                return true;
            }
        }

        if ($pl >= 5 && !in_array($action, ["importStatistic"])) {
            return true;
        }
        if ($pl >= 8 ) {
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
