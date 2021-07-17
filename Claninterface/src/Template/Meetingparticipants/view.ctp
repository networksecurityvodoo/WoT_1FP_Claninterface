<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Meetingparticipant $meetingparticipant
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Meetingparticipant'), ['action' => 'edit', $meetingparticipant->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Meetingparticipant'), ['action' => 'delete', $meetingparticipant->id], ['confirm' => __('Are you sure you want to delete # {0}?', $meetingparticipant->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Meetingparticipants'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Meetingparticipant'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Players'), ['controller' => 'Players', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Player'), ['controller' => 'Players', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Meetings'), ['controller' => 'Meetings', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Meeting'), ['controller' => 'Meetings', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="meetingparticipants view large-9 medium-8 columns content">
    <h3><?= h($meetingparticipant->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Player') ?></th>
            <td><?= $meetingparticipant->has('player') ? $this->Html->link($meetingparticipant->player->nick, ['controller' => 'Players', 'action' => 'view', $meetingparticipant->player->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Meeting') ?></th>
            <td><?= $meetingparticipant->has('meeting') ? $this->Html->link($meetingparticipant->meeting->name, ['controller' => 'Meetings', 'action' => 'view', $meetingparticipant->meeting->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Teamspeak') ?></th>
            <td><?= h($meetingparticipant->teamspeak) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($meetingparticipant->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Wot') ?></th>
            <td><?= $this->Number->format($meetingparticipant->wot) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Joined') ?></th>
            <td><?= h($meetingparticipant->joined) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($meetingparticipant->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($meetingparticipant->created) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Channel') ?></h4>
        <?= $this->Text->autoParagraph(h($meetingparticipant->channel)); ?>
    </div>
</div>
