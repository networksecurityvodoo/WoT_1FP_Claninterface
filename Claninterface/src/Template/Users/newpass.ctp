<?php
/**
 *  @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <h1><?= __('Ändern Sie Ihr Passwort') ?></h1>
        <div class="row">
            <div class="col-12">
                <?= $this->Form->control('password_old', ['type'=>'password', 'value'=>'', 'label'=>'Aktuelles Passwort'])?>
            </div>
            <div class="col-12 col-md-6">
                <?= $this->Form->control('password', ['type'=>'password', 'value'=>'', 'label'=>'Neues Passwort'])?>
            </div>
            <div class="col-12 col-md-6">
                <?= $this->Form->control('password_confirm', ['type'=>'password', 'value'=>'', 'label'=>'Passwort wiederholen'])?>
            </div>
        </div>
    </fieldset>
    <div class="row">
        <div class="col">
            <?= $this->Form->button(__('Speichern'),['class'=>'btn btn-success float-right']) ?>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>
