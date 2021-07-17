<?php
/**
 * @var AppView $this
 * @var Meeting[]|CollectionInterface $meetings alle kommenden Meetings
 * @var Meeting[]|CollectionInterface $oldMeetings alle vergangended Meetings
 * @var Clan[] $Clans
 */

use App\Model\Entity\Clan;
use App\Model\Entity\Meeting;
use App\View\AppView;
use Cake\Collection\CollectionInterface;
use Cake\I18n\Time;

?>

      <?= $this->Html->link(__('<i class="bi bi-plus"></i> Neue Veranstaltung'), ['action' => 'add'],["class"=>"btn btn-sm btn-success","escape"=>false]) ?>
<div class="meetings index large-9 medium-8 columns content">
    <h3><?= __('Kommende Veranstaltungen') ?></h3>
    <table class="table table-striped table-sm DataTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Clan</th>
                <th>Name</th>
                <th>Datum</th>
                <th>Von</th>
                <th>Bis</th>
                <th>wiederholen</th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($meetings as $meeting):
                $class= "";
                if(
                    $meeting->date->format("Y-m-d") == date("Y-m-d") &&
                    $meeting->start->diff(Time::now())->format("%R") == '+' &&
                    $meeting->end->diff(Time::now())->format("%R") == '-'
                )
                {
                    $class ="table-success";
                }
                ?>
            <tr class="<?= $class ?>">
                <td><?= $this->Number->format($meeting->id) ?></td>
                <th><?= $meeting->clan["short"] ?></th>
                <td><?= h($meeting->name) ?></td>
                <td><?= h($meeting->date->format("d.m.Y")) ?></td>
                <td><?= h($meeting->start->format("H:i")) ?></td>
                <td><?= h($meeting->end->format("H:i")) ?></td>
                <td><?= $meeting->cloned?"Ja":"Nein" ?></td>
                <td class="actions">
                    <?= $this->Html->link('<i class="bi bi-eye-fill"></i>', ['action' => 'view', $meeting->id],["class"=>"btn btn-primary btn-sm", "escape"=>false]) ?>
                    <?= $this->Html->link('<i class="bi bi-pen"></i>', ['action' => 'edit', $meeting->id],["class"=>"btn btn-warning btn-sm", "escape"=>false]) ?>
                    <?= $this->Form->postLink('<i class="bi bi-trash"></i>',['action' => 'delete', $meeting->id], ['confirm' => __('Are you sure you want to delete # {0}?', $meeting->id), "class"=>"btn btn-danger btn-sm", "escape"=>false]); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<br />
<div class="row">
    <div class="col-12">
        <h4>Teilnahmen an Veranstaltungen je Clan</h4>
        <?php foreach ($Clans as $clan): ?>
            <?= $this->Html->link($clan->short,["action"=> "eventlist",$clan->id],["class"=>"btn btn-dark"])?>
        <?php endforeach; ?>
    </div>
</div>
<br /><br />
<div class="meetings index large-9 medium-8 columns content">
    <h3><?= __('Vergangene Veranstaltungen') ?></h3>
    <table class="table table-striped table-sm DataTable">
        <thead>
        <tr>
            <th>ID</th>
            <th>Clan</th>
            <th>Name</th>
            <th>Datum</th>
            <th>Von</th>
            <th>Bis</th>
            <th>wiederholen</th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($oldMeetings as $meeting): ?>
            <tr>
                <td><?= $this->Number->format($meeting->id) ?></td>
                <th><?= $meeting->clan["short"] ?></th>
                <td><?= h($meeting->name) ?></td>
                <td data-sort="<?=$meeting->date->format("Ymd")?>"><?= h($meeting->date->format("d.m.Y")) ?></td>
                <td><?= h($meeting->start->format("H:i")) ?></td>
                <td><?= h($meeting->end->format("H:i")) ?></td>
                <td><?= $meeting->cloned?"Ja":"Nein" ?></td>
                <td class="actions">
                    <?= $this->Html->link('<i class="bi bi-eye-fill"></i>', ['action' => 'view', $meeting->id],["class"=>"btn btn-primary btn-sm", "escape"=>false]) ?>
                    <?= $this->Html->link('<i class="bi bi-pen"></i>', ['action' => 'edit', $meeting->id],["class"=>"btn btn-warning btn-sm", "escape"=>false]) ?>
                    <?= $this->Form->postLink('<i class="bi bi-trash"></i>',['action' => 'delete', $meeting->id], ['confirm' => __('Are you sure you want to delete # {0}?', $meeting->id), "class"=>"btn btn-danger btn-sm", "escape"=>false]); ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="row">
    <div class="col-12">
        <?php foreach ($Clans as $clan): ?>
        <?= $this->Html->link($clan->short,["action"=> "eventlist",$clan->id],["class"=>"btn btn-dark"])?>
        <?php endforeach; ?>
    </div>
</div>
<?= $this->element('DataTables', ['orderCol' => 3, 'order' => 'asc']) ?>
