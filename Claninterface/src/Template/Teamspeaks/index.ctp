<?php
/**
 * @var \App\View\AppView $this
 *
 * @var array $MembersOnline
 * @var Teamspeak[] $OfflineRecords
 * @var Clans[] $ClansTimeout
 */

use App\Logic\Helper\ClanRuleHelper;
use App\Model\Entity\Teamspeak;

?>
<?= $this->element('TeamspeakNav',['site' => "index"]) ?>
<div class="teamspeaks index large-9 medium-8 columns content">
    <h1>Verstoß Liste</h1>

    <h4>Diese Clans werden geprüft</h4>
    <table class="table table-sm">
        <thead>
        <tr>
            <th>Clan</th>
            <th>Prüfung aktiv bis</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($ClansTimeout as $ct){?>
            <tr>
                <td><?= $ct->Clan ?></td>
                <td><?= ($ct->bis)?:"Nicht aktiv" ?></td>
           </tr>
        <?php } ?>
        </tbody>
    </table>
    <small>* Fehlt ein Clan so hat kein Account einen Spieler des Clans hinzugefügt.</small>

    <h4>Diese Spieler waren nicht online</h4>
    <table class="DataTable table table-striped table-sm">
    <thead>
    <tr>
        <th>Clan</th>
        <th>Spieler</th>
        <th>Rang</th>
        <th>von</th>
        <th>bis</th>
        <th>Grund</th>
        <th>XXX</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($OfflineRecords as $ts){?>
        <tr>
            <td><?= $ts->player->clan->short ?></td>
            <td><?= $ts->player->nick ?></td>
            <td data-order="<?= $ts->player->rank_id ?>"><?= $ts->player->rank->isComando ? '<i class="bi bi-star-fill text-warning"></i> ':""; ?><?= $ts->player->rank->speekName ?></td>
            <td data-order="<?= $ts->start->format("ymdHi") ?>"><?= $ts->start->setTimezone("Europe/Berlin")->format("d.m.y H:i") ?></td>
            <td data-order="<?= $ts->end->format("ymdHi") ?>"><?= $ts->end->setTimezone("Europe/Berlin")->format("d.m.y H:i") ?></td>
            <td><?= ClanRuleHelper::$RuleReasons[$ts->reason] ?></td>
            <td><?= $this->Form->postLink("<i class='bi bi-trash'></i>",['action' => 'delete', $ts->id], ['confirm' => __('Eintrag von {0} am {1} löschen?', $ts->player->nick,$ts->end->format("d.m.y")),"class"=>"btn btn-danger btn-sm", "escape"=>false]) ?></td>
        </tr>
    <?php } ?>
    </tbody>
    </table>

</div>
<?= $this->element('DataTables', ['orderCol' => 3, 'order' => 'desc']) ?>
