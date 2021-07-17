<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Player[]|\Cake\Collection\CollectionInterface $players
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Player'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Clans'), ['controller' => 'Clans', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Clan'), ['controller' => 'Clans', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Ranks'), ['controller' => 'Ranks', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Rank'), ['controller' => 'Ranks', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Inactives'), ['controller' => 'Inactives', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Inactive'), ['controller' => 'Inactives', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Statistics'), ['controller' => 'Statistics', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Statistic'), ['controller' => 'Statistics', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Teamspeaks'), ['controller' => 'Teamspeaks', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Teamspeak'), ['controller' => 'Teamspeaks', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Tokens'), ['controller' => 'Tokens', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Token'), ['controller' => 'Tokens', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="players index large-9 medium-8 columns content">
    <h3><?= __('Players') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nick') ?></th>
                <th scope="col"><?= $this->Paginator->sort('clan_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('rank_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('joined') ?></th>
                <th scope="col"><?= $this->Paginator->sort('lastBattle') ?></th>
                <th scope="col"><?= $this->Paginator->sort('battle') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($players as $player): ?>
            <tr>
                <td><?= $this->Number->format($player->id) ?></td>
                <td><?= h($player->nick) ?></td>
                <td><?= $player->has('clan') ? $this->Html->link($player->clan->short, ['controller' => 'Clans', 'action' => 'view', $player->clan->id]) : '' ?></td>
                <td><?= $player->has('rank') ? $this->Html->link($player->rank->speekName, ['controller' => 'Ranks', 'action' => 'view', $player->rank->id]) : '' ?></td>
                <td><?= h($player->joined) ?></td>
                <td><?= h($player->lastBattle) ?></td>
                <td><?= $this->Number->format($player->battle) ?></td>
                <td><?= h($player->created) ?></td>
                <td><?= h($player->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $player->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $player->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $player->id], ['confirm' => __('Are you sure you want to delete # {0}?', $player->id)]) ?>
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
