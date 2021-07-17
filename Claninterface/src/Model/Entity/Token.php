<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Token Entity
 *
 * @property int $id
 * @property string $token
 * @property \Cake\I18n\FrozenTime $expires
 * @property int $player_id
 * @property string $nickname
 * @property int|null $user_id
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \App\Model\Entity\Player $player
 * @property \App\Model\Entity\User $user
 */
class Token extends Entity
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
        'token' => true,
        'expires' => true,
        'player_id' => true,
        'nickname' => true,
        'user_id' => true,
        'modified' => true,
        'created' => true,
        'player' => true,
        'user' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'token',
    ];
}
