<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Token $token
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Tokens'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Players'), ['controller' => 'Players', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Player'), ['controller' => 'Players', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="tokens form large-9 medium-8 columns content">
    <?= $this->Form->create($token) ?>
    <fieldset>
        <legend><?= __('Add Token') ?></legend>
        <?php
            echo $this->Form->control('token');
            echo $this->Form->control('expires');
            echo $this->Form->control('player_id', ['options' => $players]);
            echo $this->Form->control('nickname');
            echo $this->Form->control('user_id');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
