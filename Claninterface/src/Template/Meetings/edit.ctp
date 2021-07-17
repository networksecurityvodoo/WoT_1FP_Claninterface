<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Meeting $meeting
 */
?>

<?= $this->Html->link(__('<i class="bi bi-chevron-left"></i> zurück'), ['action' => 'index'], ["class" => "btn btn-dark btn-sm","escape"=>false]) ?>&nbsp;
<?= $this->Html->link('<i class="bi bi-eye-fill"></i>', ['action' => 'view', $meeting->id],["class"=>"btn btn-primary btn-sm", "escape"=>false]) ?>&nbsp;
<?= $this->Form->postLink('<i class="bi bi-trash"></i>',['action' => 'delete', $meeting->id], ['confirm' => __('Are you sure you want to delete # {0}?', $meeting->id), "class"=>"btn btn-danger btn-sm", "escape"=>false]); ?>



<?= $this->Form->create($meeting) ?>
<h1><?= __('Veranstaltung bearbeiten') ?></h1>
<div class="row">
    <div class="col-4">
        <?= $this->Form->control('clan_id', ['options' => $clans,"label"=>"Clan"]); ?>
    </div>
    <div class="col-8">
        <?= $this->Form->control('name'); ?>
    </div>
</div>
<div class="row">
    <div class="col-4">
        <?= $this->Form->control('date',["label" =>"Datum"]); ?>
    </div>
    <div class="col-4">
        <?= $this->Form->control('start',["label" =>"Start"]); ?>
    </div>
    <div class="col-4">
        <?= $this->Form->control('end',["label" =>"Ende"]); ?>
    </div>
</div>
<div class="row">
    <div class="col-4">
        <?= $this->Form->control('cloned',["options"=>[0 => "Nein", 1 => "Ja"],"label" =>"Wiederholen*"]); ?>
    </div>
    <div class="col-8"><br />
        * Wiederholen wird auf nein gesetzt sobald die Nachfolgeveranstaltung angelegt wird.
    </div>
</div>

<?= $this->Form->button(__('Speichern'),["class" => "btn btn-success"]) ?>
<?= $this->Form->end() ?>

