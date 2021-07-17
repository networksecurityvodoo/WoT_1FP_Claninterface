<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Statistic $statistic
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Statistics'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Players'), ['controller' => 'Players', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Player'), ['controller' => 'Players', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Tanks'), ['controller' => 'Tanks', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Tank'), ['controller' => 'Tanks', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="statistics form large-9 medium-8 columns content">
    <?= $this->Form->create($statistic) ?>
    <fieldset>
        <legend><?= __('Add Statistic') ?></legend>
        <?php
            echo $this->Form->control('battletype');
            echo $this->Form->control('damage');
            echo $this->Form->control('spotted');
            echo $this->Form->control('frags');
            echo $this->Form->control('droppedCapturePoints');
            echo $this->Form->control('battle');
            echo $this->Form->control('win');
            echo $this->Form->control('in_garage');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
