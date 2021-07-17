<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Player Entity
 *
 * @property int $id
 * @property string $nick
 * @property int|null $clan_id
 * @property int|null $rank_id
 * @property \Cake\I18n\FrozenTime $joined
 * @property \Cake\I18n\FrozenTime $lastBattle
 * @property int $battle
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Clan $clan
 * @property \App\Model\Entity\Rank $rank
 * @property \App\Model\Entity\Inactive[] $inactives
 * @property \App\Model\Entity\Statistic[] $statistics
 * @property \App\Model\Entity\Teamspeak[] $teamspeaks
 * @property \App\Model\Entity\Token[] $tokens
 * @property \App\Model\Entity\User[] $users
 * @property Meetingparticipant[] $eetingparticipants
 */
class Player extends Entity
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
        'nick' => true,
        'clan_id' => true,
        'rank_id' => true,
        'joined' => true,
        'lastBattle' => true,
        'battle' => true,
        'created' => true,
        'modified' => true,
        'clan' => true,
        'rank' => true,
        'inactives' => true,
        'statistics' => true,
        'teamspeaks' => true,
        'tokens' => true,
        'users' => true,
        'meetingparticipants' => true,
    ];
}
