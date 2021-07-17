<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Inactive $inactive
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $inactive->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $inactive->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Inactives'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Players'), ['controller' => 'Players', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Player'), ['controller' => 'Players', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="inactives form large-9 medium-8 columns content">
    <?= $this->Form->create($inactive) ?>
    <fieldset>
        <legend><?= __('Edit Inactive') ?></legend>
        <?php
            echo $this->Form->control('player_id', ['options' => $players]);
            echo $this->Form->control('battle');
            echo $this->Form->control('reason');
            echo $this->Form->control('offline');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
