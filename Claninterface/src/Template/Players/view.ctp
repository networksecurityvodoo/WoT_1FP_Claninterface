<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Player $player
 * @var \App\Model\Entity\Statistic[] $stats
 * @var int $permissionLevel
 * @var string $battletype
 */

use App\Logic\Config\StatisticsConfigHelper;
use App\Logic\Helper\StringHelper;
use App\Logic\Helper\WN8Helper;
use App\Model\Entity\Meetingparticipant;

$wn8 = 0;
$battles = 0;

$tier_battles = array();
$tier_wn = array();
$types_battles = array();
$types_wn = array();

foreach ($stats as $stat) {
    $tank_wn8 = WN8Helper::calcWN8($stat, $stat->tank) * $stat->battle;
    $wn8 += $tank_wn8;
    $battles += $stat->battle;


    if(!isset($tier_wn [$stat->tank['tier']])){
        $tier_battles [$stat->tank['tier']] =0;
        $tier_wn [$stat->tank['tier']] = 0;
    }
    if(!isset($types_wn [$stat->tank['tanktype']['name']])){
        $types_battles [$stat->tank['tanktype']['name']] =0;
        $types_wn [$stat->tank['tanktype']['name']] = 0;
    }

    $tier_battles [$stat->tank['tier']] += $stat->battle;
    $tier_wn [$stat->tank['tier']] += $tank_wn8;

    $types_battles  [$stat->tank['tanktype']['name']] += $stat->battle;
    $types_wn  [$stat->tank['tanktype']['name']] += $tank_wn8;

}

ksort($tier_battles);
ksort($tier_wn);
ksort($types_battles);
ksort($types_wn);

$label_type = "";
foreach ($types_battles as $k => $v) {
    $label_type .= "'$k',";
}
$label_tier = "";
foreach ($tier_battles as $k => $v) {
    $label_tier .= "'".StringHelper::numberToRomanRepresentation($k)."',";
}
$wn8 = $wn8 / $battles;


?>

<?php if ($permissionLevel >= 5): ?>
    <?= $this->Html->link(__('<i class="bi bi-chevron-left"></i> zurück'), ['controller' => 'Clans', 'action' => 'view', $player->clan_id], ["class" => "btn btn-dark btn-sm", "escape" => false]) ?>
<?php endif; ?>
    <?php foreach (StatisticsConfigHelper::$BattleTypesNames as $name => $val): ?>
        <?= $this->Html->link($name, ["action" => "view", $player->id, $val], ["class" => "btn btn-secondary btn-sm"]) ?>
    <?php endforeach; ?>
    <br/>
    <br/>

<div class="players view large-9 medium-8 columns content">
    <h1><?= $this->Html->image("ranks/" . $player->rank->name . ".png", ["height" => 45]) ?> <?= h($player->nick) ?></h1>
    <table class="table table-sm table-striped">
        <tr>
            <th scope="row"><?= __('Clan') ?></th>
            <td><?= $player->has('clan') ? $this->Html->image($player->clan->icon, ["height" => 30]) . " " . (($permissionLevel >= 8) ? $this->Html->link($player->clan->short, ['controller' => 'Clans', 'action' => 'view', $player->clan->id]) : $player->clan->short) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rang') ?></th>
            <td><?= $player->has('rank') ? $this->Html->image("ranks/" . $player->rank->name . ".png", ["height" => 30]) . " " . (($permissionLevel >= 8) ? $this->Html->link($player->rank->speekName, ['controller' => 'Ranks', 'action' => 'view', $player->rank->id]) : $player->rank->speekName) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('WN8') ?></th>
            <td class="<?= WN8Helper::WnColor($wn8) ?>"><?= $this->Number->format($wn8, ["locale" => 'de_DE', "precision" => 2]); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('WG-ID') ?></th>
            <td><?= $player->id ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Gefechte') ?></th>
            <td><?= $this->Number->format($player->battle, ["locale" => "de_DE"]) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Beigetreten') ?></th>
            <td><?= h($player->joined->format("d.m.Y H:i")) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Letztes Gefecht') ?></th>
            <td><?= h($player->lastBattle->format("d.m.Y H:i")) ?></td>
        </tr>
    </table>

    <br/>
    <br/>
    <div class="row">
        <div class="col-6">
            <canvas id="chart_types" class="fixed-height-chart"></canvas>
        </div>
        <div class="col-6">
            <canvas id="chart_tier" class="fixed-height-chart"></canvas>
        </div>
    </div>
    <br/>
    <br>
    <h2>Panzer Statistiken &ndash; <?= array_search($battletype, StatisticsConfigHelper::$BattleTypesNames) ?></h2>
    <table class="table DataTable table-striped table-sm">
        <thead>
        <tr>
            <th>Tier</th>
            <th>Name</th>
            <th>Typ</th>
            <th>Nation</th>
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
            $wn8 = WN8Helper::calcWN8($stat, $stat->tank);
            $sieg = $stat->win * 100 / $stat->battle;
            ?>

            <tr>
                <td data-sort="<?= $stat->tank->tier ?>"> <?= StringHelper::numberToRomanRepresentation($stat->tank->tier) ?></td>
                <td><?= $this->Html->image("tanktypes/" . ($stat->tank->premium ? "premium" : "tank") . ".png", ["height" => "20"]) ?> <?= $stat->tank->name ?></td>
                <td><?= $this->Html->image("tanktypes/" . $stat->tank->tanktype["name"] . ".png", ["height" => "20"]) ?></td>
                <td data-sort="<?= $stat->tank->nation ?>"><?= $this->Html->image("flags/" . $stat->tank->nation . ".png", ["height" => "20"]) ?></td>
                <td data-sort="<?= $stat->battle ?>"><?= $this->Number->format($stat->battle, ["locale" => 'de_DE']); ?></td>
                <td data-sort="<?= $sieg ?>"
                    class="<?= WN8Helper::SiegColor($sieg) ?>"><?= $this->Number->format($sieg, ["locale" => 'de_DE', "precision" => 2]); ?></td>
                <td data-sort="<?= $stat->damage / $stat->battle ?>"><?= $this->Number->format($stat->damage / $stat->battle, ["locale" => 'de_DE', "precision" => 2]); ?></td>
                <td data-sort="<?= $stat->frags / $stat->battle ?>"><?= $this->Number->format($stat->frags / $stat->battle, ["locale" => 'de_DE', "precision" => 2]); ?></td>
                <td data-sort="<?= $wn8 ?>"
                    class="<?= WN8Helper::WnColor($wn8) ?>"><?= $this->Number->format($wn8, ["locale" => 'de_DE', "precision" => 2]); ?></td>
                <td><?= $this->Html->link('<i class="far fa-chart-bar"></i>', ["action" => "tankStats", $player->id, $stat->tank->id, $battletype], ["escape" => false, "class" => "btn btn-dark btn-sm"]) ?></td>

            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php if ($permissionLevel >= 8): ?>
        <br/>
        <h2>Veranstaltungen</h2>
        <table class="table DataTable">
            <thead>
            <tr>
                <th>Name</th>
                <th>Datum</th>
                <th>WoT</th>
                <th>Channels</th>
                <th>Teamspeak</th>
                <th>Beigetreten</th>
                <th>XXX</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($player->meetingparticipants)):
                /** @var Meetingparticipant $participant */
                foreach ($player->meetingparticipants as $participant) :?>
                    <tr>
                        <td><?= $participant->meeting->name ?></td>
                        <td><?= $participant->meeting->date->format("d.m.Y") ?></td>
                        <td data-sort="<?= $participant->wot ?>"><?= $participant->wot ? "<i class='text-success bi bi-check2-circle'></i>" : "<i class='text-danger bi bi-exclamation-diamond-fill'></i>" ?></td>
                        <td><?= $participant->channel ?></td>
                        <td><?= $participant->teamspeak ?></td>
                        <td><?= $participant->joined->format("H:i") ?></td>
                        <td><?= $this->Form->postLink('<i class="bi bi-trash"></i>', ["controller" => 'Meetingparticipants', 'action' => 'delete', $participant->id], ['confirm' => __('Teilname von "{0}" am Event "{0}" löschen?', $player->nick, $participant->meeting->name), "class" => "btn btn-danger btn-sm", "escape" => false]); ?>
                        </td>
                    </tr>
                <?php endforeach;
            endif; ?>
            </tbody>
        </table>
    <?php endif; ?>

</div>
<script>
    var types = new Chart(
        document.getElementById('chart_types'),
        {
            type: 'radar',
            data: {
                labels: [<?= $label_type ?>],
                datasets: [
                    {
                        label: 'Gefechte',
                        backgroundColor: 'rgba(18, 12, 110,0.2)',
                        borderColor: 'rgb(18, 12, 110)',
                        data: [<?php
                        foreach ($types_battles as $v){
                            echo "'$v',";
                        }
                        ?>],
                    },
                    {
                        label: 'WN8',
                        backgroundColor: 'rgba(0, 110, 15,0.2)',
                        borderColor: 'rgb(0, 110, 15)',
                        data: [<?php
                            foreach ($types_wn as $k => $v){
                                $val = $v / $types_battles[$k];
                                echo "'$val',";
                            }
                            ?>],
                    },
                ]
            },
            options: {
                elements: {
                    line: {
                        borderWidth: 3
                    }
                }
            }
        }
    );
    var tier = new Chart(
        document.getElementById('chart_tier'),
        {
            type: 'radar',
            data: {
                labels: [<?= $label_tier ?>],
                datasets: [
                    {
                        label: 'Gefechte',
                        backgroundColor: 'rgba(18, 12, 110,0.2)',
                        borderColor: 'rgb(18, 12, 110)',
                        data: [<?php
                            foreach ($tier_battles as $v){
                                echo "'$v',";
                            }
                            ?>],
                    },
                    {
                        label: 'WN8',
                        backgroundColor: 'rgba(0, 110, 15,0.2)',
                        borderColor: 'rgb(0, 110, 15)',
                        data: [<?php
                            foreach ($tier_wn as $k => $v){
                                $val = $v / $tier_battles[$k];
                                echo "'$val',";
                            }
                            ?>],
                    },
                ]
            },
            options: {
                elements: {
                    line: {
                        borderWidth: 3
                    }
                }
            }
        }
    );
</script>
<?= $this->element('DataTables', ['orderCol' => 0, 'order' => 'desc']) ?>
