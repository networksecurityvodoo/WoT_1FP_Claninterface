<?php
/**
* @var \App\View\AppView $this
*/

use Cake\Core\Configure; ?>
<h1>Beim Claninterface anmelden</h1>
<?= $this->Form->create() ?>
<?= $this->Form->control('email',["label"=>"Deine E-Mail"]) ?>
<?= $this->Form->control('password',["label"=>"Dein Claninterface-Passwort"]) ?>
<?= $this->Form->button('Anmelden',["class"=>"btn btn-success"]) ?>
<?= $this->Form->end() ?>

<br />
<?= $this->Html->link('<i class="bi bi-person-plus-fill"></i> Neues Konto erstellen',['controller' => 'Users', 'action' => 'add'], ["escape" =>false])?><br />
<?=  $this->Html->link('<i class="bi bi-unlock-fill"></i> Passwort vergessen',['controller' => 'Users', 'action' => 'unlock'], ["escape" =>false])?><br />
<?=  $this->Html->link('<i class="fab fa-openid"></i> Login mit WarGaming-Konto (Open-ID)',"https://". Configure::read('Wargaming.server')."/wot/auth/login/?application_id=".Configure::read('Wargaming.authkey')."&display=page&redirect_uri=".$this->Url->build(["controller" => "Tokens","action" => "login"], ['escape' => false,'fullBase' => true]), ["escape" =>false])?><br />

