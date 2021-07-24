<?php
/**
 * @var \App\View\AppView $this
 * @var bool $UserIsAdmin
 * @var Player[] $Players
 * @var int $permissionLevel
 */

use App\Model\Entity\Player;
use Cake\Core\Configure;

$addAccountUrl = "https://" . Configure::read('Wargaming.server') . "/wot/auth/login/?application_id=" . Configure::read('Wargaming.authkey') . "&display=page&redirect_uri=" . $this->Url->build(["controller" => "Tokens", "action" => "receive"], ['escape' => false, 'fullBase' => true]);

?>
<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1 class="display-4">Berechtigungen</h1>

        <span class="lead">
            <?php if ($permissionLevel >= 3): ?>
                <i class="bi bi-check-circle-fill"></i>
            <?php endif; ?>
            Sie sind
            <?php if ($permissionLevel == -1): ?>
                UNBEKANNT
            <?php endif; ?>
            <?php if ($permissionLevel == 0): ?>
                Externer oder ohne WoT-Account
            <?php endif; ?>
            <?php if ($permissionLevel == 3): ?>
                Clangruppen Mitglied
            <?php endif; ?>
            <?php if ($permissionLevel == 5): ?>
                Clangruppen-Feldkommandant
            <?php endif; ?>
            <?php if ($permissionLevel == 8): ?>
                Clangruppen Kommandant
            <?php endif; ?>
            <?php if ($permissionLevel == 10): ?>
                Claninterface Administrator
            <?php endif; ?>
        </span>
    </div>
</div>

<h3>Verbundene WoT-Accounts</h3>
Das Claninterface benutzt den Rang der verbundenen WoT-Accounts um deine Berechtigungen du im Claninterface festzulegen.
Wir verwenden das Wargaming-OpenID verfahren, bei diesem Bestätigt Wargaming, dass du der Besitzer des WoT-Accounts bis.
<b>Wir erhalten weder deine E-Mail-Adresse oder dein
    Passwort</b>, alle 14 Tage muss die Verbindung erneut bestätigt werden.<br/>
<u>Folgende Daten erhalten und nutzen wir:</u>
<ul>
    <li>Benutzername</li>
    <li>vertrauliche Claninformationen</li>
    <li>Liste der Spielerfahrzeuge, inklusive Mietfahrzeuge</li>
    <li>Erweiterte Spieler-Statistiken</li>
</ul>
<?= $this->Html->link("<i class='bi bi-plus-circle-dotted'></i> WoT-Account verbinden", $addAccountUrl, ["class" => "btn btn-success btn-sm", "escape" => false]) ?>
 <i class="toggle-explain-btn bi bi-question-circle" data-toggle="tooltip" data-placement="top" title="Anleitung anzeigen"></i>
<br/> <br/>
<div class="toggle-explain">


    <strong>Anleitung</strong>
    <ol>
        <li>Auf den oberen <?= $this->Html->link("Link", $addAccountUrl) ?> klicken</li>
        <li>Bei <?= $this->Html->link("Wargaming", "https://eu.wargaming.net/", ["target" => "_blank"]) ?>einloggen
        </li>
        <li>Zugriff bestätigen</li>
        <li><b>Wenn weitere Accounts hinzugefügt werden sollen:</b>
            Bei <?= $this->Html->link("Wargaming", "https://eu.wargaming.net/", ["target" => "_blank"]) ?> ausloggen,
            bei 1. beginnen.
        </li>
    </ol>
</div>

<?php if (!$Players->count()) {
    echo "keine Accounts verbunden";
} else { ?>
    <div class="row">
        <?php foreach ($Players as $player): ?>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="connetedPlayers">
                    <span class="player-clan">[<?= $player->clanName ?>]</span>
                    <span class="player">  <?= $this->Html->link($this->Html->image("ranks/" . $player->rankIcon . ".png", ["height" => 35]) ." ".h($player->nick), ["controller" => "Players", "action" => "view", $player->id], ["escape" =>false, 'data-toggle'=>"tooltip", 'data-placement'=> "top", 'title'=>"Statistik anzeigen"]) ?></span>

                    <span class="timeout"><?= $player->expires->format("d.m.Y H:i") ?></span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

<?php } ?>
<script>
    $(document).ready(function () {
        $(".toggle-explain").hide();
        $(".toggle-explain-btn").click(function () {
            $(".toggle-explain").slideToggle();
        });
    });
</script>
