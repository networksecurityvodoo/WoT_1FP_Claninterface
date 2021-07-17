<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Rank $rank
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <?php if ($permissionLevel >= 10): ?>
        <li><?= $this->Html->link(__('Edit Rank'), ['action' => 'edit', $rank->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Rank'), ['action' => 'delete', $rank->id], ['confirm' => __('Are you sure you want to delete # {0}?', $rank->id)]) ?> </li>
       <?php endif; ?>
        <li><?= $this->Html->link(__('List Ranks'), ['action' => 'index']) ?> </li>

    </ul>
</nav>
<div class="ranks view large-9 medium-8 columns content">
    <h3><?= h($rank->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($rank->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('SpeekName') ?></th>
            <td><?= h($rank->speekName) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($rank->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sort') ?></th>
            <td><?= $this->Number->format($rank->sort) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('IsComando') ?></th>
            <td><?= $this->Number->format($rank->isComando) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($rank->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($rank->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Players') ?></h4>
        <?php if (!empty($rank->players)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Nick') ?></th>
                <th scope="col"><?= __('Clan Id') ?></th>
                <th scope="col"><?= __('Rank Id') ?></th>
                <th scope="col"><?= __('Joined') ?></th>
                <th scope="col"><?= __('PreviousDays') ?></th>
                <th scope="col"><?= __('LastBattle') ?></th>
                <th scope="col"><?= __('Battle') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($rank->players as $players): ?>
            <tr>
                <td><?= h($players->id) ?></td>
                <td><?= h($players->nick) ?></td>
                <td><?= h($players->clan_id) ?></td>
                <td><?= h($players->rank_id) ?></td>
                <td><?= h($players->joined) ?></td>
                <td><?= h($players->previousDays) ?></td>
                <td><?= h($players->lastBattle) ?></td>
                <td><?= h($players->battle) ?></td>
                <td><?= h($players->created) ?></td>
                <td><?= h($players->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Players', 'action' => 'view', $players->id]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
