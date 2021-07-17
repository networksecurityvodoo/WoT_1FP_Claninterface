<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Meetingparticipant[]|\Cake\Collection\CollectionInterface $meetingparticipants
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Meetingparticipant'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Players'), ['controller' => 'Players', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Player'), ['controller' => 'Players', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Meetings'), ['controller' => 'Meetings', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Meeting'), ['controller' => 'Meetings', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="meetingparticipants index large-9 medium-8 columns content">
    <h3><?= __('Meetingparticipants') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('player_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('meeting_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('joined') ?></th>
                <th scope="col"><?= $this->Paginator->sort('wot') ?></th>
                <th scope="col"><?= $this->Paginator->sort('teamspeak') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($meetingparticipants as $meetingparticipant): ?>
            <tr>
                <td><?= $this->Number->format($meetingparticipant->id) ?></td>
                <td><?= $meetingparticipant->has('player') ? $this->Html->link($meetingparticipant->player->nick, ['controller' => 'Players', 'action' => 'view', $meetingparticipant->player->id]) : '' ?></td>
                <td><?= $meetingparticipant->has('meeting') ? $this->Html->link($meetingparticipant->meeting->name, ['controller' => 'Meetings', 'action' => 'view', $meetingparticipant->meeting->id]) : '' ?></td>
                <td><?= h($meetingparticipant->joined) ?></td>
                <td><?= $this->Number->format($meetingparticipant->wot) ?></td>
                <td><?= h($meetingparticipant->teamspeak) ?></td>
                <td><?= h($meetingparticipant->modified) ?></td>
                <td><?= h($meetingparticipant->created) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $meetingparticipant->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $meetingparticipant->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $meetingparticipant->id], ['confirm' => __('Are you sure you want to delete # {0}?', $meetingparticipant->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
