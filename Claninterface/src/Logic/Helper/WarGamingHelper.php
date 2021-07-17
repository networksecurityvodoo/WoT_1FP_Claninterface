<?php


namespace App\Logic\Helper;


use App\Logic\Config\WgApi;
use App\Model\Entity\Clan;
use App\Model\Entity\Player;
use App\Model\Table\PlayersTable;
use App\Model\Table\RanksTable;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;
use DateTime;
use Wargaming\API;

class WarGamingHelper
{
    /** @var API API Schnittstelle zu WG */
    private $api = null;
    private $accounts_info = null;

    /**
     * @return null
     */
    public function getAccountsInfo()
    {
        return $this->accounts_info;
    }

    public function __construct()
    {
        $this->api = WgApi::getWG_API();

    }

    /** Sucht ein Spielername bei WoT
     * @param string $search Spielername
     * @return array|bool|mixed ID
     * @throws \Exception
     */
    public function searchPlayer($search)
    {
        $account = $this->api->get('wot/account/list', array('fields' => 'account_id', 'type' => 'exact', 'search' => $search));
        return $account;
    }

    /**
     * Sucht einen Clan anhand des Clan Tag
     * @param Clan $clan
     * @throws \Exception
     */
    public function searchClanInfo($clan)
    {
        $wgClanInfo = $this->api->get("wot/clans/list", ["limit" => 1, "search" => $clan->short, "fields" => "clan_id,name,tag,emblems.x256"]);
        if (count($wgClanInfo)) {

            $wgClanInfo = $wgClanInfo[0];

            $clan->name = $wgClanInfo->name;
            $clan->id = $wgClanInfo->clan_id;
            $clan->icon = $wgClanInfo->emblems->x256->wowp;
            $clan->short = $wgClanInfo->tag;
            return $clan;
        }
        return false;

    }

    /**
     * Findet die wichtigsten Claninfos üder die ClanID
     * @param Clan $clan
     * @throws \Exception
     */
    public function getClanInfo($clan)
    {
        $wgClanInfo = $this->api->get("wot/clans/info", ["clan_id" => $clan->id, "fields" => "clan_id,name,tag,emblems.x256"]);
        if ($wgClanInfo) {
            $wgClanInfo = $wgClanInfo->{$clan->id};

            $clan->name = $wgClanInfo->name;
            $clan->id = $wgClanInfo->clan_id;
            $clan->icon = $wgClanInfo->emblems->x256->wowp;
            $clan->short = $wgClanInfo->tag;
            return $clan;
        }
        return false;
    }

    /** Aktualisiert die Spieler die dem Clan angehören in der DB
     * @param int $clan_id
     * @return false|int
     * @throws \Exception
     */
    public function updateClanMembers($clan_id)
    {
        /**
         * @var PlayersTable $PlayersTable
         */
        $PlayersTable = TableRegistry::getTableLocator()->get('Players');

        //Step 1: Clan mitgliedschaft austragen
        /**
         * @var Player[] $players
         */
        $players = $PlayersTable->find("all")->where(["clan_id" => $clan_id]);
        foreach ($players as $player) {
            $player->clan_id = null;
            $player->clan = null;
            $PlayersTable->save($player);
        }

        //Step 2: Mitglieder von der WGAPI abfragen
        $WGClanData = $this->api->get("wot/clans/info", ["clan_id" => $clan_id, "fields" => "members"]);
        if ($WGClanData) {
            $members = $WGClanData->$clan_id->members;
            $anz = 0;

            $membersList = "";
            foreach ($members as $member) {
                $membersList .= $member->account_id . ",";
            }
            $this->getPlayersInfos($membersList);


            foreach ($members as $member) {
                $players = $PlayersTable->find("all")->where(["id" => $member->account_id]);
                $player = null;
                //
                if ($players->count()) {
                    //vorhandener Spieler
                    $player = $players->first();
                } else {
                    //neuer Player
                    $player = $PlayersTable->newEntity();
                    $player->id = $member->account_id;

                }

                //alle Felder werden neu geschrieben, daten könnten sich geändert haben
                $player->joined = DateTime::createFromFormat('U', $member->joined_at);
                $player->clan_id = $clan_id;
                $player->nick = $member->account_name;
                $player->rank_id = RanksHelper::string2rank($member->role);
                $player->lastBattle = $this->getLastBattle($member->account_id);
                $player->battle = $this->getBattleCount($member->account_id);

                $saved = $PlayersTable->save($player);
                $anz++;
            }
            return $anz;

        }
        return false;
    }

    public function getPlayersInfos($accounts)
    {
        $this->accounts_info = $this->api->get("wot/account/info", ["account_id" => $accounts]);
    }

    /** Liefert den Zeitpunkt des letzen Gefechts eines Spielers anhand der Account ID
     * @param $acc_id
     * @return DateTime|false
     */
    public function getLastBattle($acc_id)
    {
        //nur Abfragen wenn Daten unbekannt
        if (!isset($this->accounts_info->$acc_id)) {
            $this->getPlayersInfos($acc_id);
        }
        $time = $this->accounts_info->$acc_id->last_battle_time;
        return DateTime::createFromFormat('U', $time);
    }

    /** Liefert die Anzahl der Gefechte eines Spielers anhand der Account ID
     * @param $acc_id
     * @return int
     */
    public function getBattleCount($acc_id)
    {
        //nur Abfragen wenn Daten unbekannt
        if (!isset($this->accounts_info->$acc_id)) {
            $this->getPlayersInfos($acc_id);
        }
        return $this->accounts_info->$acc_id->statistics->all->battles;
    }

    /**
     * Findet alle Spieler die gerade online sind
     * @param bool $reportMissingToken schreibt einen log wenn Tokens zu einem Clan Fehlen
     * @param null|int $clan NULL für alle Clans (Cron=1) oder CLAN:ID
     */
    public function getOnlinePlayers($clan = null)
    {
        $PLayersTable = TableRegistry::getTableLocator()->get('Players');
        $ClansTable = TableRegistry::getTableLocator()->get('Clans');
        $Clans = $ClansTable->find("all");
        $Clans = $Clans
            ->innerJoinWith("Players")
            ->innerJoinWith("Players.Tokens")
            ->select(["Clans.id", "token" => "Tokens.token"])
            ->where(["Tokens.expires >" => $Clans->func()->now()])
            ->group("Clans.id");

        $players = array();
        foreach ($Clans as $clan) {

            $resp = $this->api->get("wgn/clans/info/", ["clan_id" => $clan->id, "access_token" => $clan->token, "fields" => "private.online_members", "extra" => "private.online_members"]);
            if (isset($resp->{$clan->id}->private->online_members)) {
                $player_list = $resp->{$clan->id}->private->online_members;
                foreach ($player_list as $player_id) {
                    $player = $PLayersTable->find("all")->contain(["Clans"])->where(["Players.id" => $player_id])->first();
                    if ($player) {
                        $players [] = $player;
                        //  dump($player);
                    }
                }
            }
        }
        return $players;
    }

    public function isPlayerOnline($WoT_Players, $ts)
    {
        foreach ($WoT_Players as $player) {
            if (StringHelper::str_contains(strtolower($ts), strtolower($player->nick))) {
                return true;
            }
        }
        return false;
    }
    public function getPlayerByTsNick($nick){
        $connection = ConnectionManager::get('default');
        $res = $connection->execute("SELECT id FROM players WHERE locate(nick,?) LIMIT 1",[$nick])->fetchAll('assoc');

        if(isset($res[0]["id"]) && $res[0]["id"]) {
            $id = $res[0]["id"];
            return TableRegistry::getTableLocator()->get('Players')->get($id);;
        }
        return false;
    }
    public static function getClanListArray(){
        $ClansTable = TableRegistry::getTableLocator()->get('Clans');
        $clans = $ClansTable->find("all");
        $clan_array = [];
        /**
         * @var Clan $clan
         */
        foreach ($clans as $clan){
            $clan_array []=$clan->id;
        }
        return $clan_array;
    }

    public function getOldDays($player_id,$joined){
        $clan_array = self::getClanListArray();

        $resp = $this->api->get("wot/clans/memberhistory/", ["account_id" => $player_id]);
        $data = $resp->{$player_id};

        $sum =strtotime(date("Y-m-d H:i:s")) - strtotime($joined->format("Y-m-d H:i:s"));

        foreach ($data as $clan_hist){
            if(in_array($clan_hist->clan_id,$clan_array) ){
                $sum += $clan_hist->left_at - $clan_hist->joined_at;
            }
        }

        return floor($sum / (60*60*24));
    }
}
