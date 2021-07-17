<?php
namespace App\Model\Entity;

use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;

/**
 * Teamspeak Entity
 *
 * @property int $id
 * @property int $player_id
 * @property FrozenTime $start
 * @property FrozenTime $end
 * @property int $reason
 * @property FrozenTime $modified
 * @property FrozenTime $created
 *
 * @property \App\Model\Entity\Player $player
 */
class Teamspeak extends Entity
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
        'start' => true,
        'end' => true,
        'reason' => true,
        'modified' => true,
        'created' => true,
        'player' => true,
    ];
}
