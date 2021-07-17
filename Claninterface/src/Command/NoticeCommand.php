<?php

namespace App\Command;

use App\Logic\Helper\TeamSpeakQueryHelper;
use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class NoticeCommand extends Command
{
    public function execute(Arguments $args, ConsoleIo $io)
    {
        $this->TeamSpeakSurveillance();
    }

    private function TeamSpeakSurveillance(){
        $clansTable = TableRegistry::getTableLocator()->get('Clans');

        $clanWithCheck = $clansTable
            ->find("all")
            ->select(["Clan" => "Clans.short", "bis" => "max(Tokens.expires)"])
            ->leftJoinWith("Players")
            ->innerJoinWith("Players.Tokens");
        $clanWithCheck->where(["Tokens.expires >" => $clanWithCheck->func()->now()])
            ->group("Clans.id");

        $allClans = $clansTable->find("all")->where(["cron" => 1]);

        $msg = PHP_EOL."[u]Teamspeaküberwachungsmeldung vom ".date("d.m.Y")." um ".date("H")." Uhr:[/u]".PHP_EOL;
        $msgOkay  = "";
        $allClansChecked = true;
        foreach ($allClans as $clan){
            $clanChecked = false;
            foreach ($clanWithCheck as $clanCheck){
                if($clan->short == $clanCheck->Clan){
                    $clanChecked = true;
                    $msgOkay .= "[b][{$clan->short}][/b] {$clan->name} wird noch bis zum {$clanCheck->bis} geprüft.".PHP_EOL;
                    break;
                }
            }
            if($clanChecked == false){
                $allClansChecked = false;
                $msg .= "[b][{$clan->short}][/b] {$clan->name} wird nicht geprüft.".PHP_EOL;
            }
        }

        if(!$allClansChecked) {
            $NoticeGroups = Configure::read('Teamspeak.NoticeGroups');
            foreach ($NoticeGroups as $groups) {
                (new TeamSpeakQueryHelper())->msgServerGroup($groups, $msg.$msgOkay);
            }
        }

    }
}
