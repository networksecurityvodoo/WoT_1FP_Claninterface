<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Clan $clan
 */
?>


        <?= $this->Html->link('<i class="bi bi-arrow-left-circle"></i> Zurück', ['action' => 'index'],["class"=>"btn btn-dark ","escape"=>false]) ?>

<div class="clans form large-9 medium-8 columns content">
    <?= $this->Form->create($clan) ?>
    <fieldset>
        <legend><?= __('Clan zum Interface hinzufügen') ?></legend>
        <?php
            echo $this->Form->control('short',['label'=>"Clan Tag"]);
        ?>
        <small>* Alle weiteren Informationen werden Abgerufen</small>
    </fieldset>
    <?= $this->Form->button('<i class="bi bi-plus-circle"></i> Hinzufügen',["class"=>"btn btn-success","escape"=>false]) ?>
    <?= $this->Form->end() ?>
</div>
