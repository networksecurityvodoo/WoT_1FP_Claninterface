<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Meetingparticipant Entity
 *
 * @property int $id
 * @property int $player_id
 * @property int $meeting_id
 * @property \Cake\I18n\FrozenTime $joined
 * @property string $channel
 * @property int $wot
 * @property string $teamspeak
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \App\Model\Entity\Player $player
 * @property \App\Model\Entity\Meeting $meeting
 */
class Meetingparticipant extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'player_id' => true,
        'meeting_id' => true,
        'joined' => true,
        'channel' => true,
        'wot' => true,
        'teamspeak' => true,
        'modified' => true,
        'created' => true,
        'player' => true,
        'meeting' => true,
    ];
}
