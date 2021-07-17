<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Token $token
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Token'), ['action' => 'edit', $token->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Token'), ['action' => 'delete', $token->id], ['confirm' => __('Are you sure you want to delete # {0}?', $token->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Tokens'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Token'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Players'), ['controller' => 'Players', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Player'), ['controller' => 'Players', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="tokens view large-9 medium-8 columns content">
    <h3><?= h($token->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Token') ?></th>
            <td><?= h($token->token) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Player') ?></th>
            <td><?= $token->has('player') ? $this->Html->link($token->player->nick, ['controller' => 'Players', 'action' => 'view', $token->player->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nickname') ?></th>
            <td><?= h($token->nickname) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($token->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User Id') ?></th>
            <td><?= $this->Number->format($token->user_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Expires') ?></th>
            <td><?= h($token->expires) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($token->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($token->created) ?></td>
        </tr>
    </table>
</div>
