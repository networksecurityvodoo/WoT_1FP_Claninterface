<?php

namespace App\Command;

use App\Logic\Helper\MeetingsHelper;
use App\Logic\Helper\TankDataHelper;
use App\Logic\Helper\WarGamingHelper;
use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\ORM\TableRegistry;

class MeetingCommand extends Command
{

    public function execute(Arguments $args, ConsoleIo $io)
    {
        MeetingsHelper::createFollowMeeting();
        MeetingsHelper::findParticipant();

    }

}
