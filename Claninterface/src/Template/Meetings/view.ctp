<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Meeting $meeting
 */
?>
<?= $this->Html->link(__('<i class="bi bi-chevron-left"></i> zurück'), ['action' => 'index'], ["class" => "btn btn-dark btn-sm", "escape" => false]) ?>&nbsp;
<?= $this->Html->link('<i class="bi bi-pen"></i>', ['action' => 'edit', $meeting->id],["class"=>"btn btn-warning btn-sm", "escape"=>false]) ?>&nbsp;
<?= $this->Form->postLink('<i class="bi bi-trash"></i>',['action' => 'delete', $meeting->id], ['confirm' => __('Are you sure you want to delete # {0}?', $meeting->id), "class"=>"btn btn-danger btn-sm", "escape"=>false]); ?>

<br />
<br />
<h3><strong>[<?= $meeting->clan->short ?>]</strong> <?= h($meeting->name) ?> <small>am: <?= $meeting->date->format("d.m.Y") ?></small></h3>
<table class="table table-striped table-sm">
    <tr><th>Clan</th><td>[<?= $meeting->clan->short ?>] <?= $meeting->clan->name ?></td></tr>
    <tr><th>Name</th><td><?= $meeting->name ?></td></tr>
    <tr><th>Datum</th><td> <?= $meeting->date->format("d.m.Y") ?></td></tr>
    <tr><th>Uhrzeit</th><td><?= $meeting->start->format("H:i") ?> - <?= $meeting->end->format("H:i") ?> </td></tr>
    <tr><th>Wiederholung</th><td><?= $meeting->cloned ?"Wird zum ".$meeting->date->addDay(7)->format("d.m.Y")." wiederholt":"Wird nicht wiederholt"?>
</table>
<br />
<h4>Teilnehmer</h4>
<table class="table DataTable">
    <thead>
    <tr>
        <th>Nick</th>
        <th>Rang</th>
        <th>WoT</th>
        <th>Channels</th>
        <th>Teamspeak</th>
        <th>Beigetreten</th>
        <th>XXX</th>
    </tr>
    </thead>
<tbody>
<?php if(!empty($meeting->meetingparticipants)):
    foreach ($meeting->meetingparticipants as $participant) :?>
        <tr>
            <td><?= $this->Html->link( $participant->player->nick, ["controller" => "players","action"=>"view",$participant->player->id]) ?></td>
            <td data-sort="<?=$participant->player->rank->sort ?>"><?= $this->Html->image("ranks/". $participant->player->rank->name.".png",["height"=>"25"])?> <?= $participant->player->rank->speekName ?></td>
            <td data-sort="<?=$participant->wot ?>"><?= $participant->wot?"<i class='text-success bi bi-check2-circle'></i>":"<i class='text-danger bi bi-exclamation-diamond-fill'></i>"?></td>
            <td><?= $participant->channel ?></td>
            <td><?= $participant->teamspeak ?></td>
            <td><?= $participant->joined->format("H:i") ?></td>
            <td><?= $this->Form->postLink('<i class="bi bi-trash"></i>',["controller" => 'Meetingparticipants','action' => 'delete', $participant->id], ['confirm' => __('Teilname von "{0}" am Event "{0}" löschen?', $participant->player->nick ,$meeting->name), "class"=>"btn btn-danger btn-sm", "escape"=>false]); ?>
            </td>
        </tr>
<?php  endforeach;
endif; ?>
</tbody>
</table>
<?php if(empty($meeting->meetingparticipants)): ?>
    <small><i>-- Keine Teilnehmer --</i></small>
<?php endif; ?>
<?= $this->element('DataTables', ['orderCol' => 2, 'order' => 'asc']) ?>
