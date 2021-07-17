<?php
/**
 * @var \App\View\AppView $this
 * @var User $user
 */

use App\Model\Entity\User; ?>

<h1>Passwort vergessen</h1>
Bitte trage deine E-Mail ein, du erhältst ein neues Passwort per E-Mail zugestellt.
<?= $this->Form->create() ?>
<?= $this->Form->control('email',["label"=>"Deine E-Mail"]) ?>
<?= $this->Form->button('Neues Passwort anfordern',["class"=>"btn btn-success"]) ?>
<?= $this->Form->end() ?>
<br />
<br />
<?= $this->Html->link('<i class="bi bi-person-plus-fill"></i> Neues Konto erstellen',['controller' => 'Users', 'action' => 'add'], ["escape" =>false])?><br />
<?=  $this->Html->link('Beim Claninterface einloggen',['controller' => 'Users', 'action' => 'login'], ["escape" =>false])?><br />


