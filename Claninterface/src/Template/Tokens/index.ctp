<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Token[]|\Cake\Collection\CollectionInterface $tokens
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Token'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Players'), ['controller' => 'Players', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Player'), ['controller' => 'Players', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="tokens index large-9 medium-8 columns content">
    <h3><?= __('Tokens') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('token') ?></th>
                <th scope="col"><?= $this->Paginator->sort('expires') ?></th>
                <th scope="col"><?= $this->Paginator->sort('player_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nickname') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tokens as $token): ?>
            <tr>
                <td><?= $this->Number->format($token->id) ?></td>
                <td><?= h($token->token) ?></td>
                <td><?= h($token->expires) ?></td>
                <td><?= $token->has('player') ? $this->Html->link($token->player->nick, ['controller' => 'Players', 'action' => 'view', $token->player->id]) : '' ?></td>
                <td><?= h($token->nickname) ?></td>
                <td><?= $this->Number->format($token->user_id) ?></td>
                <td><?= h($token->modified) ?></td>
                <td><?= h($token->created) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $token->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $token->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $token->id], ['confirm' => __('Are you sure you want to delete # {0}?', $token->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
    <a href="https://api.worldoftanks.eu/wot/auth/login/?application_id=85b73842eb81bb2370706961cad362f7&display=page&redirect_uri=http://localhost/wotClan/Claninterface/tokens/receive">Create Token</a>
</div>
