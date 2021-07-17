<?php
/**
 * @var \App\View\AppView $this
 * @var string $site
 */
?>

<?= ($site != "tsOnline")?   $this->Html->link("TS3 Admin",        ['controller' => 'Teamspeaks', 'action' => 'tsOnline'],   ["class" => "btn btn-dark btn-sm"]).'&nbsp;':"" ?>
<?= ($site != "nowOffline")? $this->Html->link("Live Verstöße",    ['controller' => 'Teamspeaks', 'action' => 'nowOffline'], ["class" => "btn btn-dark btn-sm"]).'&nbsp;':"" ?>
<?= ($site != "players")?    $this->Html->link("Spieler Verstöße", ['controller' => 'Teamspeaks', 'action' => 'players'],    ["class" => "btn btn-dark btn-sm"]).'&nbsp;':"" ?>
<?= ($site != "index")?      $this->Html->link("Verstoße Liste",   ['controller' => 'Teamspeaks', 'action' => 'index'],      ["class" => "btn btn-dark btn-sm"]).'&nbsp;':"" ?>
