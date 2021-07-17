<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tanktype $tanktype
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Tanktype'), ['action' => 'edit', $tanktype->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Tanktype'), ['action' => 'delete', $tanktype->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tanktype->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Tanktypes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tanktype'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="tanktypes view large-9 medium-8 columns content">
    <h3><?= h($tanktype->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($tanktype->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($tanktype->id) ?></td>
        </tr>
    </table>
</div>
