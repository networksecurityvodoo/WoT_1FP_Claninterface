<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Rank Entity
 *
 * @property int $id
 * @property string $name
 * @property string $speekName
 * @property int $sort
 * @property int $isComando
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Player[] $players
 */
class Rank extends Entity
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
        'speekName' => true,
        'sort' => true,
        'isComando' => true,
        'created' => true,
        'modified' => true,
        'players' => true,
    ];
}
