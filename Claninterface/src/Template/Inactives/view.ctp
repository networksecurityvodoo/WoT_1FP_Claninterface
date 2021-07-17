<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Inactive $inactive
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Inactive'), ['action' => 'edit', $inactive->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Inactive'), ['action' => 'delete', $inactive->id], ['confirm' => __('Are you sure you want to delete # {0}?', $inactive->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Inactives'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Inactive'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Players'), ['controller' => 'Players', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Player'), ['controller' => 'Players', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="inactives view large-9 medium-8 columns content">
    <h3><?= h($inactive->player_id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Player') ?></th>
            <td><?= $inactive->has('player') ? $this->Html->link($inactive->player->nick, ['controller' => 'Players', 'action' => 'view', $inactive->player->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($inactive->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Battle') ?></th>
            <td><?= $this->Number->format($inactive->battle) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Offline') ?></th>
            <td><?= h($inactive->offline) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($inactive->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($inactive->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Reason') ?></h4>
        <?= $this->Text->autoParagraph(h($inactive->reason)); ?>
    </div>
</div>
