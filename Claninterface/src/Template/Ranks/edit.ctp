<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Rank $rank
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $rank->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $rank->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Ranks'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Players'), ['controller' => 'Players', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Player'), ['controller' => 'Players', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="ranks form large-9 medium-8 columns content">
    <?= $this->Form->create($rank) ?>
    <fieldset>
        <legend><?= __('Edit Rank') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('speekName');
            echo $this->Form->control('sort');
            echo $this->Form->control('isComando');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
