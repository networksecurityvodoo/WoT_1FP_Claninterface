<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Tank Entity
 *
 * @property int $id
 * @property string $name
 * @property int $tier
 * @property int $tankType_id
 * @property float $expDef
 * @property float $expFrag
 * @property float $expSpot
 * @property float $expDamage
 * @property float $expWinRate
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property string $nation
 * @property int $premium
 *
 * @property \App\Model\Entity\Tanktype $tank_type
 * @property \App\Model\Entity\Statistic[] $statistics
 */
class Tank extends Entity
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
        'name' => true,
        'tier' => true,
        'tankType_id' => true,
        'expDef' => true,
        'expFrag' => true,
        'expSpot' => true,
        'expDamage' => true,
        'expWinRate' => true,
        'created' => true,
        'modified' => true,
        'nation' => true,
        'premium' => true,
        'tank_type' => true,
        'statistics' => true,
    ];
}
