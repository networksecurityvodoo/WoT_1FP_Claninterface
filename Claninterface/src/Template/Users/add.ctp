<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Benutzer-Konto anlegen') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('email');
            echo $this->Form->control('password');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Anlegen'),["class"=>"btn btn-success"]) ?>
    <?= $this->Form->end() ?>
</div>
<br />
<br />
<?=  $this->Html->link('Beim Claninterface einloggen',['controller' => 'Users', 'action' => 'login'], ["escape" =>false])?><br />
<?=  $this->Html->link('<i class="bi bi-unlock-fill"></i> Passwort vergessen',['controller' => 'Users', 'action' => 'unlock'], ["escape" =>false])?><br />
