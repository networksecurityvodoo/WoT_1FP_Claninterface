<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Meetingregistration[]|\Cake\Collection\CollectionInterface $meetingregistrations
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Meetingregistration'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Players'), ['controller' => 'Players', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Player'), ['controller' => 'Players', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Meetings'), ['controller' => 'Meetings', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Meeting'), ['controller' => 'Meetings', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="meetingregistrations index large-9 medium-8 columns content">
    <h3><?= __('Meetingregistrations') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('player_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('meeting_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($meetingregistrations as $meetingregistration): ?>
            <tr>
                <td><?= $this->Number->format($meetingregistration->id) ?></td>
                <td><?= $meetingregistration->has('player') ? $this->Html->link($meetingregistration->player->nick, ['controller' => 'Players', 'action' => 'view', $meetingregistration->player->id]) : '' ?></td>
                <td><?= $meetingregistration->has('meeting') ? $this->Html->link($meetingregistration->meeting->name, ['controller' => 'Meetings', 'action' => 'view', $meetingregistration->meeting->id]) : '' ?></td>
                <td><?= $this->Number->format($meetingregistration->status) ?></td>
                <td><?= h($meetingregistration->modified) ?></td>
                <td><?= h($meetingregistration->created) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $meetingregistration->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $meetingregistration->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $meetingregistration->id], ['confirm' => __('Are you sure you want to delete # {0}?', $meetingregistration->id)]) ?>
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
