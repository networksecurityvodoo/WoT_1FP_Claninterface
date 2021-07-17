<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Clan[]|\Cake\Collection\CollectionInterface $clans
 * @var int $permissionLevel
 */
?>

<div class="clans index large-9 medium-8 columns content">
    <h3><?= __('Clan Verwaltung') ?></h3>

    <?php foreach ($clans as $clan): ?>
        <div class="clan">
            <div class="row">
                <div class=" col-lg-2 -col-md-3 col-sm-4 col-xs-12">
                    <?= $this->Html->image($clan->icon) ?>
                </div>
                <div class=" col-lg-10 col-md-9 col-sm-8 col-xs-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="clan-tag">[<?= $clan->short ?>]</div>
                            <div class="clan-name"><?= $clan->name ?></div>
                        </div>
                        <div class="col-12">
                            <?= $this->Html->link('<i class="bi bi-info-circle"></i> Details', ['action' => 'view', $clan->id], ["class" => "btn btn-info btn-sm", "escape" => false]) ?>
                            <?php if ($permissionLevel >= 10): ?>
                            <?= $this->Form->postLink('<i class="bi bi-graph-up"></i> Spieler Infos abrufen', ['action' => 'getClanMembers', $clan->id], ["class" => "btn btn-secondary  btn-sm", "escape" => false]) ?>
                            <?= $this->Form->postLink('<i class="bi bi-graph-up"></i> Spieler Statisticen abrufen', ["controller" => "players", 'action' => 'importStatistic', $clan->id], ["class" => "btn btn-secondary  btn-sm", "escape" => false]) ?>
                            <?= $this->Form->postLink('<i class="bi bi-cloud-arrow-down-fill"></i> Clandaten abrufen', ['action' => 'renew', $clan->id], ["class" => "btn btn-secondary  btn-sm", "escape" => false]) ?>
                            <?= $this->Form->postLink('<i class="bi bi-trash"></i>  Löschen', ['action' => 'delete', $clan->id], ['confirm' => __('Wollen Sie den Clan [' . $clan->short . '] wirklich aus dem Interface löschen löschen?', $clan->id), "class" => "btn btn-danger  btn-sm", "escape" => false]) ?>
                            <?= $this->Form->postLink('<i class="bi bi-arrow-down-up"></i> ' . ($clan->cron ? "Deaktivieren" : "Aktivieren"), ['action' => 'toggle', $clan->id], ['confirm' => __('Wollen Sie den Clan [' . $clan->short . '] wirklich in der automatischen Verfolgung umschalten?', $clan->id), "class" => "btn btn-warning  btn-sm", "escape" => false]) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if ($clan->cron == 0) {
                        echo "<i class='float-right text-danger'>* Für diesen Clan stehen nicht alle Funktionen zu Verfügung.</i>";
                    } ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if ($permissionLevel >= 10): ?>
        <div class="clan">
            <div class="row">
                <div class=" col-lg-2 -col-md-3 col-sm-4 col-xs-12">
                    <i class="bi bi-plus-circle clan-add"></i>
                </div>
                <div class=" col-lg-10 col-md-9 col-sm-8 col-xs-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="clan-tag">Clan hinzufügen</div>
                            <?= $this->Html->link('Neuen Clan in das Clan Interface aufnehmen', ['action' => 'add']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
