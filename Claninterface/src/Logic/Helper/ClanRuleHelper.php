<?php


namespace App\Logic\Helper;


use App\Model\Entity\Player;
use App\Model\Entity\Teamspeak;
use Cake\ORM\TableRegistry;

class ClanRuleHelper
{
    public static $RuleReasons = array(
        0 => "Unbekannt/Offen",
        1 => "TSONLINE: Spieler betrat Teamspeak",
        2 => "TSONLINE: Spieler loggte sich bei WoT aus"
    );

    /**
     * @param Player[] $inGamePlayers
     * @param array $teamspeakUsers
     */
    public function checkTeamSpeak($inGamePlayers, $teamspeakUsers)
    {
        if($teamspeakUsers == false){
            return  array();
        }
        $TSTable = TableRegistry::getTableLocator()->get('Teamspeaks');
        $offllineRecords = $TSTable->find("all")->contain(["players"])->where(["end <" => "1970-01-02"]);


        //CLOSE OPEN
        /** @var Teamspeak $record */
        foreach ($offllineRecords as $record){

            foreach ($teamspeakUsers as $user) {
                if (StringHelper::str_contains(strtolower($user), strtolower($record->Players['nick']))) {
                    $record->end = new \DateTime();
                    $record->reason = 1;
                    $TSTable->save($record);
                    break 2;
                }
            }
            $ingame = false;
            foreach ($inGamePlayers as $player) {
                if ($player->id == $record->player_id) {
                    $ingame = true;
                    break;
                }
            }
            if(!$ingame){
                $record->end = new \DateTime();
                $record->reason = 2;
                $TSTable->save($record);
            }
        }

        //test for new
        $resp = array();
        foreach ($inGamePlayers as $player) {
            $online = false;
            $ts_nick = "";
            foreach ($teamspeakUsers as $user) {
                if (StringHelper::str_contains(strtolower($user), strtolower($player->nick))) {
                    $online = true;
                    $ts_nick = $user;
                    break;
                }
            }


            if ($online) {
                $resp []= [true, $player->clan->short, $player->nick,$ts_nick];
            } else {
                $resp []= [false, $player->clan->short, $player->nick,false];

                //Spieler ist offline ohne TS (neuer Eintrag)
                if($TSTable->find("all")->where(["end <" => "1970-01-02", "player_id"=>$player->id])->count() == 0){
                    /** @var Teamspeak $tsOffline */
                    $tsOffline = $TSTable->newEntity();
                    $tsOffline->player_id = $player->id;
                    $tsOffline->start = new \DateTime();
                    $tsOffline->end = new \DateTime('1970-01-01');
                    $tsOffline->reason = 0;
                    $TSTable->save($tsOffline);
                }
            }
        }
        return $resp;
    }
}
