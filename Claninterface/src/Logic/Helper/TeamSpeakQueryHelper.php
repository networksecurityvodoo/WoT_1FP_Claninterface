<?php

namespace App\Logic\Helper;

use App\Logic\Config\TeamSpeakQueryConfig;
use Cake\Core\Configure;
use TeamSpeak3;
use TeamSpeak3_Adapter_ServerQuery_Exception;
use TeamSpeak3_Exception;
use TeamSpeak3_Node_Abstract;
use TeamSpeak3_Node_Host;
use TeamSpeak3_Node_Server;

class TeamSpeakQueryHelper
{
    /** @var  TeamSpeak3_Node_Abstract|TeamSpeak3_Node_Host|TeamSpeak3_Node_Server|null $virtualServer */
    private $virtualServer = null;
    private $nick = null;

    public function __construct()
    {
        try {
            $tsQueryConfig = new TeamSpeakQueryConfig();
            $virtualServerArr = $tsQueryConfig->getVirtualServer();
            $this->virtualServer = $virtualServerArr[0];
            $this->nick = $virtualServerArr[1];
        } catch (\Exception $exception) {
            $this->virtualServer = false;
            $this->nick = false;
        }
    }

    public function getClientlist($fullList = false)
    {
        if ($this->virtualServer == false) {
            return false;
        }
        $vs = $this->virtualServer;
        $arr_ClientList = $vs->clientList();

        $x = array();
        foreach ($arr_ClientList as $client) {

            $n = $client->__toString();
            if ($this->nick != $n) {
                if ($fullList == true) {
                    $x[] = $client;
                } else {
                    $x[] = $n;
                }
            }
        }
        return $x;
    }

    //region KICK POKE MSG by Name
    public function kickPlayerByName($name)
    {
        $this->virtualServer->clientGetByName($name)->kick(TeamSpeak3::KICK_SERVER, "kicked by Clansystem, user: " . $_SERVER['PHP_AUTH_USER']);
    }

    public function banPlayerByName($name, $seconds = 86400, $msg = "Sie wurden vorläufig gebannt.")
    {
        $this->virtualServer->clientGetByName($name)->ban($seconds, $msg);
    }

    public function pokePlayerByName($name, $msg = "Du wurdest angestupst")
    {
        $this->virtualServer->clientGetByName($name)->poke($msg);
    }

    public function msgPlayerByName($name, $message)
    {
        $this->virtualServer->clientGetByName($name)->message($message);
    }
    //endregion

    //region KICK POKE MSG by UID
    public function kickPlayerByUID($uid)
    {
        $this->virtualServer->clientGetByUid($uid)->kick(TeamSpeak3::KICK_SERVER, "kicked by Clansystem, user: " . $_SERVER['PHP_AUTH_USER']);
    }

    public function banPlayerByUID($uid, $seconds = 86400, $msg = "Sie wurden vorläufig gebannt.")
    {
        $this->virtualServer->clientGetByUid($uid)->ban($seconds, $msg);
    }

    public function pokePlayerByUID($uid, $msg = "Du wurdest angestupst")
    {
        $this->virtualServer->clientGetByUid($uid)->poke($msg);
    }

    public function msgPlayerByUID($uid, $message)
    {
        $this->virtualServer->clientGetByUid($uid)->message($message);
    }

    //endregion

    public function markTSonline(&$Members_Array, $TS3_Array, $seachKey = "nickname", $insertKey = "ts3_online")
    {
        foreach ($Members_Array as &$members) {
            $members[$insertKey] = 0;
            foreach ($TS3_Array as $ts) {
                $ik = strpos($ts, $members[$seachKey]);
                if ($ik !== false) {
                    $members[$insertKey] = 1;
                }
            }
        }
    }

    public function getOnlinePlayersInfo()
    {

        if ($this->virtualServer == false) {
            return false;
        }
        $result = array();

        $wgh = new WarGamingHelper();
        $WoT_Players = $wgh->getOnlinePlayers();


        $i = 0;
        $channels = $this->virtualServer->channelList();
        foreach ($channels as $channel) {
            $clients = $channel->clientList();
            foreach ($clients as $client) {
                if ($this->nick != $client->toString()) {
                    $i++;
                    $online = $wgh->isPlayerOnline($WoT_Players, $client->toString());

                    $dbPlayer = $wgh->getPlayerByTsNick($client->toString());

                    $isAdmin = false;
                    $adminGroups = Configure::read('Teamspeak.AdminGroups');
                    foreach ($client->memberOf() as $group) {
                        if ($group instanceof \TeamSpeak3_Node_Servergroup) {
                            if (in_array($group->getId(), $adminGroups)) {
                                $isAdmin = true;
                            }
                        }
                    }

                    $result [] = [
                        'id' => $dbPlayer ? $dbPlayer->id : $dbPlayer,
                        'ingame' => $dbPlayer ? $dbPlayer->nick : $dbPlayer,
                        'clan' => $dbPlayer ? $dbPlayer->clan_id : $dbPlayer,
                        'teamspeak' => $client->toString(),
                        'teamspeakUID' => $client["client_unique_identifier"],
                        'channel' => $channel->toString(),
                        'online' => $online,
                        'admin' => $isAdmin

                    ];
                }
            }
        }
        return $result;
    }

    public function msgServerGroup($id, $message)
    {
        /**
         * @var \TeamSpeak3_Node_Servergroup $sq
         */
        $sq = $this->virtualServer->serverGroupGetById($id);

        //Get All Clients from Servergroup
        foreach ($sq->clientList() as $client) {
            try {
                $this->msgPlayerByName($client["client_nickname"], $message);
            } catch (TeamSpeak3_Adapter_ServerQuery_Exception  $exception) {
                //Player of Servergroup is offline :)
            }
        }
    }
}
