<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Statistic $statistic
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Statistic'), ['action' => 'edit', $statistic->tank_id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Statistic'), ['action' => 'delete', $statistic->tank_id], ['confirm' => __('Are you sure you want to delete # {0}?', $statistic->tank_id)]) ?> </li>
        <li><?= $this->Html->link(__('List Statistics'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Statistic'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Players'), ['controller' => 'Players', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Player'), ['controller' => 'Players', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Tanks'), ['controller' => 'Tanks', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tank'), ['controller' => 'Tanks', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="statistics view large-9 medium-8 columns content">
    <h3><?= h($statistic->tank_id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Player') ?></th>
            <td><?= $statistic->has('player') ? $this->Html->link($statistic->player->nick, ['controller' => 'Players', 'action' => 'view', $statistic->player->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tank') ?></th>
            <td><?= $statistic->has('tank') ? $this->Html->link($statistic->tank->name, ['controller' => 'Tanks', 'action' => 'view', $statistic->tank->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Battletype') ?></th>
            <td><?= h($statistic->battletype) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Damage') ?></th>
            <td><?= $this->Number->format($statistic->damage) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Spotted') ?></th>
            <td><?= $this->Number->format($statistic->spotted) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Frags') ?></th>
            <td><?= $this->Number->format($statistic->frags) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('DroppedCapturePoints') ?></th>
            <td><?= $this->Number->format($statistic->droppedCapturePoints) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Battle') ?></th>
            <td><?= $this->Number->format($statistic->battle) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Win') ?></th>
            <td><?= $this->Number->format($statistic->win) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('In Garage') ?></th>
            <td><?= $this->Number->format($statistic->in_garage) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date') ?></th>
            <td><?= h($statistic->date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($statistic->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($statistic->created) ?></td>
        </tr>
    </table>
</div>
