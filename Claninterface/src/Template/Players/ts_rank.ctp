<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Player $form
 * @var string $js_player_array
 *
 * @var int $days
 * @var array $rank
 * @var \App\Model\Entity\Player $player
  */
?>
<h1>Mein Teamspeak Rang</h1>
Finde deinen aktuellen Rang im Teamspeak heraus,<br />
dafür wird deine Mitgliedszeit abgefragt, beachte dass wir nur deine letzten zehn Clans berücksichtigen können an dieser Stelle.<br />
Dein Rang kann unter umständen von diesem Rang hier abweichen, frag dazu bitte beim Kommando nach.<br />
Bist du noch keine 24 Stunden im Clan ist diese Funktion möglicherweise nicht verfügbar.<br />
<br />
<?= $this->Form->create($form) ?>
<?=  $this->Form->control('player', ['id' => 'player', 'label' => 'WoT Nickname eintragen:', 'type' => 'Text']);?>
<?= $this->Form->button(__('<i class="bi bi-cloud-download"></i> Rang abrufen'),["escape" => false,"class"=>"btn btn-primary"]) ?>
<?= $this->Form->end() ?>
<?php if(isset($days)): ?>
<hr />
Hallo <?= $player->nick ?>,<br />
anbei die Zusammenfassung deiner Mitgliedschaft im Clan:<br />
<br />
Dein TeamSpeak Rang ist mindestens <b><?= $this->Html->image("ranks/ts3/".$rank["img"],["height"=>50])?> <?= $rank["name"] ?></b>,
    da du seit <b><?= $days ?></b> Tagen in der Clangruppe bist.<br />
<br />
<b><u>Ingame-Infos:</u></b>
<table class="table-striped table-sm table">
    <tr><th>Clan</th><td><?= $this->Html->image($player->clan->icon,["height"=>35]) ?>[<?=$player->clan->short?>] <?=$player->clan->name?></td></tr>
    <tr><th>Rang</th><td><?= $this->Html->image("ranks/".$player->rank->name.".png",["height"=>35]) ?> <?=$player->rank->speekName?></td></tr>
    <tr><th>Gefechte</th><td><?= $this->Number->format($player->battle,["locale"=> "de_DE"]) ?></td></tr>
    <tr><th>Beigetreten</th><td><?=$player->joined->format("d.m.Y H:i")?></td></tr>
    <tr><th>Letztes Gefecht</th><td><?=$player->lastBattle->format("d.m.Y H:i")?></td></tr>
</table>




<?php endif; ?>
<script>
    $(document).ready(function () {
        $("#player").autocomplete({
            source: <?= $js_player_array ?>
        });
    });
</script>
