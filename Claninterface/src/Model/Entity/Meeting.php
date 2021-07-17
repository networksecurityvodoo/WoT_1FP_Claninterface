<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Meeting Entity
 *
 * @property int $id
 * @property string $name
 * @property \Cake\I18n\FrozenDate $date
 * @property \Cake\I18n\FrozenTime $start
 * @property \Cake\I18n\FrozenTime $end
 * @property int $cloned
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $created
 * @property int $clan_id
 *
 * @property \App\Model\Entity\Clan $clan
 * @property \App\Model\Entity\Meetingparticipant[] $meetingparticipants
 */
class Meeting extends Entity
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
        'date' => true,
        'start' => true,
        'end' => true,
        'cloned' => true,
        'modified' => true,
        'created' => true,
        'clan_id' => true,
        'clan' => true,
        'meetingparticipants' => true,
    ];
}
