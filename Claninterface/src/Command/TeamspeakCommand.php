<?php
namespace App\Command;

use App\Logic\Helper\ClanRuleHelper;
use App\Logic\Helper\TankDataHelper;
use App\Logic\Helper\TeamSpeakQueryHelper;
use App\Logic\Helper\WarGamingHelper;
use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\ORM\TableRegistry;

class TeamspeakCommand extends Command
{

    public function  execute(Arguments $args, ConsoleIo $io)
    {
        $ruleReport = $this->checkTeamspeakRules();
        $io->out("done");

    }
    private function checkTeamspeakRules(){
        $CR = new ClanRuleHelper();
        return $CR->checkTeamSpeak((new WarGamingHelper())->getOnlinePlayers(),(new TeamSpeakQueryHelper())->getClientlist());

    }

}
