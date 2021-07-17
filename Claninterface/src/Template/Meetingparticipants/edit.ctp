<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Meetingparticipant $meetingparticipant
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $meetingparticipant->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $meetingparticipant->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Meetingparticipants'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Players'), ['controller' => 'Players', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Player'), ['controller' => 'Players', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Meetings'), ['controller' => 'Meetings', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Meeting'), ['controller' => 'Meetings', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="meetingparticipants form large-9 medium-8 columns content">
    <?= $this->Form->create($meetingparticipant) ?>
    <fieldset>
        <legend><?= __('Edit Meetingparticipant') ?></legend>
        <?php
            echo $this->Form->control('player_id', ['options' => $players]);
            echo $this->Form->control('meeting_id', ['options' => $meetings]);
            echo $this->Form->control('joined');
            echo $this->Form->control('channel');
            echo $this->Form->control('wot');
            echo $this->Form->control('teamspeak');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
