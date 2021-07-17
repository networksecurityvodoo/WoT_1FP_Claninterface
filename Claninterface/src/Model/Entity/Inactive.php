<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Inactive Entity
 *
 * @property int $id
 * @property int $player_id
 * @property int $battle
 * @property string|null $reason
 * @property \Cake\I18n\FrozenTime $offline
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Player $player
 */
class Inactive extends Entity
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
        'battle' => true,
        'reason' => true,
        'offline' => true,
        'created' => true,
        'modified' => true,
        'player' => true,
    ];
}
