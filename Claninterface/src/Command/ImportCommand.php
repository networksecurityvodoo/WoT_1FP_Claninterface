<?php
namespace App\Command;

use App\Logic\Helper\TankDataHelper;
use App\Logic\Helper\WarGamingHelper;
use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\ORM\TableRegistry;

class ImportCommand extends Command
{

    public function  execute(Arguments $args, ConsoleIo $io)
    {
        $players = $this->importPlayer();
        $io->out("Es wurden $players Spieler gefunden.");

        $tanks = $this->importTanks();
        $io->out("Es wurden $tanks Panzer gefunden.");

        $clans = $this->renewClanData();
        $io->out("Clandaten erneuert");
    }
    private function renewClanData(){
        $ClansTable = TableRegistry::getTableLocator()->get('Clans');

        $clans = $ClansTable->find("all");
        $WgApi = new WarGamingHelper();
        foreach ($clans as $clan) {
             $WgApi->getClanInfo($clan);
        }

    }
    private function importPlayer()
    {
        $ClansTable = TableRegistry::getTableLocator()->get('Clans');

        $clans = $ClansTable->find("all");
        $WgApi = new WarGamingHelper();
        $anz = 0;
        foreach ($clans as $clan) {
            $anz += $WgApi->updateClanMembers($clan->id);
        }
        return $anz;
    }
    private function importTanks(){
        $TankHelper = new TankDataHelper();
        $TankListr=  $TankHelper->getTankList();
         return $TankHelper->importTank($TankListr,true);
    }
}
