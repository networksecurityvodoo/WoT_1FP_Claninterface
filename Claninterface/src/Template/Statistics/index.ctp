<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Statistic[]|\Cake\Collection\CollectionInterface $statistics
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Statistic'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Players'), ['controller' => 'Players', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Player'), ['controller' => 'Players', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Tanks'), ['controller' => 'Tanks', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Tank'), ['controller' => 'Tanks', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="statistics index large-9 medium-8 columns content">
    <h3><?= __('Statistics') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('player_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tank_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('battletype') ?></th>
                <th scope="col"><?= $this->Paginator->sort('damage') ?></th>
                <th scope="col"><?= $this->Paginator->sort('spotted') ?></th>
                <th scope="col"><?= $this->Paginator->sort('frags') ?></th>
                <th scope="col"><?= $this->Paginator->sort('droppedCapturePoints') ?></th>
                <th scope="col"><?= $this->Paginator->sort('battle') ?></th>
                <th scope="col"><?= $this->Paginator->sort('win') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('in_garage') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($statistics as $statistic): ?>
            <tr>
                <td><?= $statistic->has('player') ? $this->Html->link($statistic->player->nick, ['controller' => 'Players', 'action' => 'view', $statistic->player->id]) : '' ?></td>
                <td><?= $statistic->has('tank') ? $this->Html->link($statistic->tank->name, ['controller' => 'Tanks', 'action' => 'view', $statistic->tank->id]) : '' ?></td>
                <td><?= h($statistic->date) ?></td>
                <td><?= h($statistic->battletype) ?></td>
                <td><?= $this->Number->format($statistic->damage) ?></td>
                <td><?= $this->Number->format($statistic->spotted) ?></td>
                <td><?= $this->Number->format($statistic->frags) ?></td>
                <td><?= $this->Number->format($statistic->droppedCapturePoints) ?></td>
                <td><?= $this->Number->format($statistic->battle) ?></td>
                <td><?= $this->Number->format($statistic->win) ?></td>
                <td><?= h($statistic->modified) ?></td>
                <td><?= h($statistic->created) ?></td>
                <td><?= $this->Number->format($statistic->in_garage) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $statistic->tank_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $statistic->tank_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $statistic->tank_id], ['confirm' => __('Are you sure you want to delete # {0}?', $statistic->tank_id)]) ?>
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
