<?php
namespace App\Command;

use App\Logic\Helper\PlayerDataHelper;
use App\Logic\Helper\TankDataHelper;
use App\Logic\Helper\WarGamingHelper;
use App\Model\Entity\Clan;
use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\ORM\TableRegistry;

class StatsCommand extends Command
{
    public function  execute(Arguments $args, ConsoleIo $io)
    {
        $ClansTable = TableRegistry::getTableLocator()->get('Clans');
        $clans = $ClansTable->find("all")->where(["cron" => 1]);

        /**
         * @var Clan $clan
         */
        foreach ($clans as $clan) {
            $PlayerHelper = new PlayerDataHelper();
            $c = $PlayerHelper->importPlayerStatistic($clan->id, $io);
            $io->out($clan->short." Es wurden $c Datensätze geladen.");
        }
    }
}
