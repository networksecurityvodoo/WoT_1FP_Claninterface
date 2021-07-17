<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Statistic Entity
 *
 * @property int $player_id
 * @property int $tank_id
 * @property \Cake\I18n\FrozenDate $date
 * @property string $battletype
 * @property int $damage
 * @property int $spotted
 * @property int $frags
 * @property int $droppedCapturePoints
 * @property int $battle
 * @property int $win
 * @property int $in_garage
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $created
 * @property int $shots
 * @property int $xp
 * @property int $hits
 * @property int $survived
 * @property int $tanking
 *
 * @property \App\Model\Entity\Player $player
 * @property \App\Model\Entity\Tank $tank
 */
class Statistic extends Entity
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
        'tank_id' => true,
        'date' => true,
        'battletype' => true,
        'damage' => true,
        'spotted' => true,
        'frags' => true,
        'droppedCapturePoints' => true,
        'battle' => true,
        'win' => true,
        'in_garage' => true,
        'modified' => true,
        'created' => true,
        'shots' => true,
        'xp' => true,
        'hits' => true,
        'survived' => true,
        'tanking' => true,
        'player' => true,
        'tank' => true,
    ];
}
