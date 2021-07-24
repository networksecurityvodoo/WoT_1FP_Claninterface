<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Meetingregistration Entity
 *
 * @property int $id
 * @property int|null $player_id
 * @property int|null $meeting_id
 * @property int|null $status
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property \Cake\I18n\FrozenTime|null $created
 *
 * @property \App\Model\Entity\Player $player
 * @property \App\Model\Entity\Meeting $meeting
 */
class Meetingregistration extends Entity
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
        'status' => true,
        'modified' => true,
        'created' => true,
        'player' => true,
        'meeting' => true,
    ];
}
