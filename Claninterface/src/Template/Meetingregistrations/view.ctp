<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Meetingregistration $meetingregistration
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Meetingregistration'), ['action' => 'edit', $meetingregistration->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Meetingregistration'), ['action' => 'delete', $meetingregistration->id], ['confirm' => __('Are you sure you want to delete # {0}?', $meetingregistration->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Meetingregistrations'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Meetingregistration'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Players'), ['controller' => 'Players', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Player'), ['controller' => 'Players', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Meetings'), ['controller' => 'Meetings', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Meeting'), ['controller' => 'Meetings', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="meetingregistrations view large-9 medium-8 columns content">
    <h3><?= h($meetingregistration->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Player') ?></th>
            <td><?= $meetingregistration->has('player') ? $this->Html->link($meetingregistration->player->nick, ['controller' => 'Players', 'action' => 'view', $meetingregistration->player->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Meeting') ?></th>
            <td><?= $meetingregistration->has('meeting') ? $this->Html->link($meetingregistration->meeting->name, ['controller' => 'Meetings', 'action' => 'view', $meetingregistration->meeting->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($meetingregistration->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $this->Number->format($meetingregistration->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($meetingregistration->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($meetingregistration->created) ?></td>
        </tr>
    </table>
</div>
