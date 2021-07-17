<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Clan $clan
 */
?>
<?= $this->Html->link(__('<i class="bi bi-chevron-left"></i> zurück'), ['action' => 'index'], ["class" => "btn btn-sm btn-dark", "escape"=>false]) ?>
<br/>
<div class="row">
    <div class="col-12">
        <center><?= $this->Html->image($clan->icon) ?></center>
        <center><h3><b>[<?= h($clan->short) ?>]</b> <?= h($clan->name) ?></h3></center>
    </div>
    <div class="col-12">
        <br/>
        WG-Clan ID: <?= $clan->id ?><br/>
        <?php if($clan->cron == 0){echo "<span class='text-danger'>Für diesen Clan stehen nicht alle Funktionen zu Verfügung.<br />Es werden nicht alle Daten regelmäßig abgerufen.</span>";}?>
    </div>
    <div class="col-12">
        <h4><?= __('Mitglieder') ?></h4>
        <?php if (!empty($clan->players)): ?>
            <table class="table table-sm DataTable">
                <thead>
                <tr>
                    <th><?= __('Nick') ?></th>
                    <th><?= __('Rang') ?></th>
                    <th><?= __('Beigetreten') ?></th>
                    <th><?= __('Letztes Gefecht') ?></th>
                    <th><?= __('Gefechte') ?></th>
                    <th><?= __('Ansehen') ?></th>
                </tr>
                </thead>
                <?php foreach ($clan->players as $players): ?>
                    <tr>

                        <td><?= h($players->nick) ?></td>
                        <td data-order="<?= h($players["rank"]["sort"]) ?>"><?= $this->Html->image("ranks/". $players["rank"]["name"].".png",["height"=>"35"])?> <?= h($players["rank"]["speekName"]) ?><?= $players["rank"]["isComando"]?'<i class="bi bi-star-fill text-warning"></i> ':'' ?></td>
                        <td data-order="<?= $players->joined->format("U") ?>"><?= h($players->joined->format("d.m.Y H:i")) ?></td>

                        <td data-order="<?= $players->lastBattle->format("U") ?>"><?= h($players->lastBattle->format("d.m.Y H:i")) ?></td>
                        <td data-order="<?= $players->battle ?>"><?= $this->Number->format($players->battle,["locale"=> "de_DE"]); ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('Ansehen'), ['controller' => 'Players', 'action' => 'view', $players->id]) ?>
                            </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
</div>
<?= $this->element('DataTables', ['orderCol' => 1, 'order' => 'desc']) ?>
