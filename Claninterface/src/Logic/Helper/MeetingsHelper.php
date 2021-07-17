<?php


namespace App\Logic\Helper;


use App\Model\Entity\Meeting;
use App\Model\Entity\Meetingparticipant;
use App\Model\Table\MeetingsTable;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;

class MeetingsHelper
{
    public static function createFollowMeeting()
    {
        /**
         * @var MeetingsTable $MeetingsTable
         */
        $MeetingsTable = TableRegistry::getTableLocator()->get('Meetings');
        $running = $MeetingsTable->find("all")->where(["cloned"=> 1,"date" => date("Y-m-d"), "start <="=> date("H:i:00"),"end >="=> date("H:i:00")]);
        /**
         * @var Meeting $meeting
         */
        foreach ($running as $meeting){

            $newMeeting = $MeetingsTable->newEntity($meeting->toArray());
            unset($newMeeting->created);
            unset($newMeeting->id);
            $newMeeting->date = $newMeeting->date->addDay(7);
            $MeetingsTable->save($newMeeting);

            $meeting->cloned = 0;
            $MeetingsTable->save($meeting);
        }
    }
    public static function findParticipant()
    {
        /**
         * @var MeetingsTable $MeetingsTable
         */
        $MeetingsTable = TableRegistry::getTableLocator()->get('Meetings');
        $ParticipantsTable = TableRegistry::getTableLocator()->get('Meetingparticipants');
        $running = $MeetingsTable->find("all")->where(["date" => date("Y-m-d"), "start <="=> date("H:i:00"),"end >="=> date("H:i:00")]);
        /**
         * @var Meeting $meeting
         */
        foreach ($running as $meeting){
            $online  = (new TeamSpeakQueryHelper())->getOnlinePlayersInfo();
            foreach ($online as $item){
                if($item["clan"] == $meeting->clan_id) {

                     $participant = $ParticipantsTable->find("all")->where(["player_id" => $item['id'], "meeting_id" => $meeting->id]);
                     if($participant->count()){
                         $participant = $participant->first();
                         if($item['online']) {
                             $participant->wot = $item['online'] ? 1 : 0;
                         }
                         if (strpos($participant->channel, $item['channel']) === false) {
                             $participant->channel .= ", ".$item['channel'];
                         }
                     }else{
                         $participant = $ParticipantsTable->newEntity();
                         $participant->meeting_id = $meeting->id;
                         $participant->player_id = $item['id'];
                         $participant->joined = Time::now();
                         $participant->channel = $item['channel'];
                         $participant->wot = $item['online']?1:0;
                         $participant->teamspeak =$item['teamspeak'];
                     }


                    $ParticipantsTable->save($participant);
                }

            }
        }
    }
}
