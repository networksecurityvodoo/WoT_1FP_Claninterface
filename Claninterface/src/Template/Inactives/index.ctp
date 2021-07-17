<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Inactive[]|\Cake\Collection\CollectionInterface $inactives
 */

use Cake\I18n\Time;

?>



<div class="inactives index large-9 medium-8 columns content">
    <h1><?= __('Abmeldungen') ?></h1>

    Alle Abmeldungen von Clanmitgliedern die seit dem weniger als <u>500 Gefechte</u> gefahren haben.<br />
    <?= $this->Html->link(__('Abmeldung eintragen'), ['action' => 'add']) ?><br />
    <br />



    <table class="table table-sm table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Spieler</th>
                <th>Gefechte</th>
                <th>Rückkehr</th>
                <th>Abmeldedatum</th>
                <th>Grund</th>
                <th>XXX</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($inactives as $inactive):
                $diff =$inactive->player->battle - $inactive->battle;

                if($diff > 500){
                    continue;
                }
                $battleClass ="";
                if($diff > 50){
                   $battleClass = "bg-warning";
                }
                if($diff > 150){
                    $battleClass = "bg-danger";
                }

                $offlineClass = "";
                $dateUnknown = false;
                if($inactive->offline < Time::today()){
                    $offlineClass = "bg-warning";
                }
                if($inactive->offline->addDay(30) < Time::today()){
                    $offlineClass = "bg-danger";
                }
                if($inactive->offline->format("Y-m-d") == "1970-01-01"){
                    $offlineClass = "bg-info";
                    $dateUnknown = true;
                }

                ?>
            <tr>
                <td><?= $this->Number->format($inactive->id) ?></td>
                <td><?= $inactive->has('player') ? $this->Html->link($inactive->player->nick, ['controller' => 'Players', 'action' => 'view', $inactive->player->id]) : '' ?></td>
                <td class="<?= $battleClass?>"><?= $this->Number->format($inactive->battle, ["locale" => "de_DE"]) ?> (+<?= $diff ?>)</td>
                <td class="<?= $offlineClass ?>"><?=$dateUnknown?"Unbekannt":$inactive->offline->format("d.m.Y") ?></td>
                <td><?= h($inactive->created->format("d.m.Y")) ?></td>
                <td><?= $inactive->reason?></td>
                <td class="actions">
                    <?= $this->Form->postLink(__('<i class="bi bi-trash"></i>'), ['action' => 'delete', $inactive->id], ['confirm' => __('Abmeldung von {0} löschen?', $inactive->player->nick),"escape"=>false, "class"=>"btn btn-danger btn-sm"]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
