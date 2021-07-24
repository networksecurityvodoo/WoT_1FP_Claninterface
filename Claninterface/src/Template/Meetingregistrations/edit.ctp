<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Meetingregistration $meetingregistration
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $meetingregistration->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $meetingregistration->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Meetingregistrations'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Players'), ['controller' => 'Players', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Player'), ['controller' => 'Players', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Meetings'), ['controller' => 'Meetings', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Meeting'), ['controller' => 'Meetings', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="meetingregistrations form large-9 medium-8 columns content">
    <?= $this->Form->create($meetingregistration) ?>
    <fieldset>
        <legend><?= __('Edit Meetingregistration') ?></legend>
        <?php
            echo $this->Form->control('player_id', ['options' => $players, 'empty' => true]);
            echo $this->Form->control('meeting_id', ['options' => $meetings, 'empty' => true]);
            echo $this->Form->control('status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
