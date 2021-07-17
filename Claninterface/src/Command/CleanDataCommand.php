<?php

namespace App\Command;

use App\Logic\Helper\PlayerDataHelper;
use App\Logic\Helper\TeamSpeakQueryHelper;
use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class CleanDataCommand extends Command
{
    public function execute(Arguments $args, ConsoleIo $io)
    {
        $ph = new PlayerDataHelper();

        $io->out($ph->cleanUpPlayer());
    }


}
