<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Rank[]|\Cake\Collection\CollectionInterface $ranks
 * @var int $permissionLevel
 */
?>
<div class="ranks index large-9 medium-8 columns content">
    <h3><?= __('Ränge') ?></h3>
    <table class="table table-striped table-sm">
        <thead>
        <tr>
            <th>ID</th>
            <th>Icon</th>
            <th>Rang</th>
            <th>sort</th>
            <th>Admin</th>
            <th>XXX</th>

        </tr>
        </thead>
        <tbody>
        <?php foreach ($ranks as $rank): ?>
            <tr>
                <td><?= $this->Number->format($rank->id) ?></td>
                <td><?= $this->Html->image("ranks/" . $rank->name . ".png", ["height" => "50"]) ?></td>
                <td><?= h($rank->speekName) ?></td>
                <td><?= $this->Number->format($rank->sort) ?></td>
                <td><?= $rank->isComando ? '<i class="bi bi-star-fill text-warning"></i> ' : '<i class="bi bi-star"></i>'; ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $rank->id]) ?>

                    <?php if ($permissionLevel >= 10): ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $rank->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $rank->id], ['confirm' => __('Are you sure you want to delete # {0}?', $rank->id)]) ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
