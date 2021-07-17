<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tank $tank
 * @var \App\Model\Entity\Statistic[] $stats
 * @var string $battletype
 */

use App\Logic\Config\StatisticsConfigHelper;
use App\Logic\Helper\StringHelper;
use App\Logic\Helper\WN8Helper;

?>
<?= $this->Html->link(__('<i class="bi bi-chevron-left"></i> Zurück'), ['action' => 'index'],["class" => "btn btn-dark btn-sm", "escape" => false]) ?>
<?php foreach (StatisticsConfigHelper::$BattleTypesNames as $name => $val): ?>
    <?= $this->Html->link($name,["action"=>"view",$tank->id, $val],["class"=>"btn btn-secondary btn-sm"]) ?>
<?php endforeach; ?>

<br />
<br />


<div class="tanks view large-9 medium-8 columns content">

    <h1><?= $this->Html->image("flags/". $tank->nation.".png",["height"=>"35"])?> <?= h($tank->name) ?></h1>
    <br />
    <h4>Informationen</h4>
    <table class="table table-sm table-striped">
        <tr>
            <th scope="row"><?= __('Premiumstatus') ?></th>
            <td><?= $this->Html->image("tanktypes/". ($tank->premium?"premium":"tank").".png",["height"=>"20"])?> <?=$tank->premium?"Premium":"Standard" ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tier') ?></th>
            <td><?= StringHelper::numberToRomanRepresentation($tank->tier) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Panzerklasse') ?></th>
            <td><?= $tank->has('tanktype') ? $this->Html->image("tanktypes/" . $tank->tanktype["name"] . ".png", ["height" => "20"])." ".$tank->tanktype['name'] : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nation') ?></th>
            <td><?= $this->Html->image("flags/". $tank->nation.".png",["height"=>"20"])?> <?= h(ucwords($tank->nation)) ?></td>
        </tr>
    </table>
    <h4>Statistische Daten</h4>
    <table class="table table-sm table-striped">
        <tr>
            <th scope="row"><?= __('Schaden') ?></th>
            <td><?= $this->Number->format($tank->expDamage, ["locale" => 'de_DE']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Kills') ?></th>
            <td><?= $this->Number->format($tank->expFrag, ["locale" => 'de_DE']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Siegrate') ?></th>
            <td><?= $this->Number->format($tank->expWinRate, ["locale" => 'de_DE']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Basis-Verteidigung') ?></th>
            <td><?= $this->Number->format($tank->expDef, ["locale" => 'de_DE']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Aufklärung') ?></th>
            <td><?= $this->Number->format($tank->expSpot, ["locale" => 'de_DE']) ?></td>
        </tr>
    </table>
</div>
<div >
    <h4>Spieler Statistik &ndash; <?= array_search($battletype, StatisticsConfigHelper::$BattleTypesNames) ?></h4>
    <table class="table DataTable table-striped table-sm">
        <thead>
        <tr>
            <th>Clan</th>
            <th>Spieler</th>
            <th>Gefechte</th>
            <th>Siegrate</th>
            <th>Schaden</th>
            <th>Kills</th>
            <th>WN8</th>
            <th>XXX</th>
        </tr>
        </thead>
        <tbody>
    <?php foreach ($stats as $stat):
        $wn8 = WN8Helper::calcWN8($stat,$stat->tank);
        $sieg = $stat->win*100/$stat->battle;

        ?>

        <tr>
            <td><?=$this->Html->link($stat->player->clan->short,["controller"=>"clans","action"=>"view", $stat->player->clan_id]) ?></td>
            <td><?= $this->Html->link($stat->player->nick,["controller"=>"players","action"=>"view", $stat->player->id,$battletype]) ?></td>
            <td data-sort="<?=  $stat->battle ?>"><?= $this->Number->format( $stat->battle  , ["locale" => 'de_DE']);?></td>
            <td data-sort="<?= $sieg ?>" class="<?= WN8Helper::SiegColor($sieg) ?>"><?= $this->Number->format( $sieg , ["locale" => 'de_DE', "precision"=>2]); ?></td>
            <td data-sort="<?= $stat->damage /$stat->battle ?>"><?=$this->Number->format(  $stat->damage /$stat->battle  , ["locale" => 'de_DE', "precision"=>2]);?></td>
            <td data-sort="<?= $stat->frags /$stat->battle ?>"><?= $this->Number->format( $stat->frags /$stat->battle  , ["locale" => 'de_DE', "precision"=>2]);?></td>
            <td data-sort="<?= $wn8 ?>" class="<?= WN8Helper::WnColor($wn8) ?>"><?= $this->Number->format( $wn8 , ["locale" => 'de_DE', "precision"=>2]);?></td>
            <td><?= $this->Html->link('<i class="far fa-chart-bar"></i>',["controller"=>"players","action"=>"tankStats",$stat->player->id,$stat->tank->id, $battletype],["escape"=>false,"class"=>"btn btn-dark btn-sm"]) ?></td>

        </tr>
    <?php endforeach;?>
        </tbody>
    </table>
</div>
<?= $this->element('DataTables', ['orderCol' => 1, 'order' => 'asc']) ?>
