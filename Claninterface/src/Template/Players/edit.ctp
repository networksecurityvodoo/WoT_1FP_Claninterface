<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Player $player
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $player->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $player->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Players'), ['action' => 'index']) ?></li>
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
<div class="players form large-9 medium-8 columns content">
    <?= $this->Form->create($player) ?>
    <fieldset>
        <legend><?= __('Edit Player') ?></legend>
        <?php
            echo $this->Form->control('nick');
            echo $this->Form->control('clan_id', ['options' => $clans, 'empty' => true]);
            echo $this->Form->control('rank_id', ['options' => $ranks, 'empty' => true]);
            echo $this->Form->control('joined');
            echo $this->Form->control('lastBattle');
            echo $this->Form->control('battle');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
