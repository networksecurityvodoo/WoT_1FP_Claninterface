<?php


namespace App\Logic\Config;


use App\Logic\Helper\StringHelper;
use Cake\Core\Configure;
use TeamSpeak3;

 class TeamSpeakQueryConfig
{
    private $host = null;
    private $port = null;
    private $uid  = null;

    private $user = null;
    private $pass = null;
    private $nick = null;


    public $protectedServerGroups = [];




    public function __construct(){
        $this->host = Configure::read('TeamspeakQueryConnection.host');
        $this->port = Configure::read('TeamspeakQueryConnection.port');
        $this->uid = Configure::read('TeamspeakQueryConnection.uid');

        $this->user = Configure::read('TeamspeakQueryLogin.user');
        $this->pass = Configure::read('TeamspeakQueryLogin.pass');
        $this->nick = Configure::read('TeamspeakQueryLogin.loginName');

    }
    public function getVirtualServer() {

        $nick = $this->getNick();

        $ts3_ServerInstance = TeamSpeak3::factory("serverquery://{$this->user}:{$this->pass}@{$this->host}:{$this->port}/?nickname=$nick");
        return [$ts3_ServerInstance->serverGetById($this->uid),$nick];

    }

    public function getNick(){
        $n = $this->nick;

        $n = $n." (".StringHelper::generateRandomString(5).")";

        $n = preg_replace("/[^a-zA-Z0-9() ]/", " ", $n);
        $n = preg_replace('/\s+/', '_', $n);

        return $n;
    }
}
