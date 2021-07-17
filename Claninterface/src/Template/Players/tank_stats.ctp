<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Statistic[] $stats
 * @var Player $Player
 * @var string $battletype
 */

$stats = array_reverse($stats);

use App\Logic\Config\StatisticsConfigHelper;
use App\Logic\Helper\WN8Helper;
use App\Model\Entity\Player;

?>
<?= $this->Html->link(__('<i class="bi bi-chevron-left"></i> zurück'), ['controller' => 'Players', 'action' => 'view', $Player->id,$battletype], ["class" => "btn btn-dark btn-sm", "escape" => false]) ?>

<?php foreach (StatisticsConfigHelper::$BattleTypesNames as $name => $val): ?>
    <?= $this->Html->link($name,["action"=>"tankStats",$Player->id,$stats[0]->tank->id, $val],["class"=>"btn btn-secondary btn-sm"]) ?>
<?php endforeach; ?>
<br />
<br />
<h2> Auswertung: Spieler: <?= $Player->nick ?>, Panzer: <?= $stats[0]->tank->name ?>, Gefechtstyp: <?= array_search($battletype, StatisticsConfigHelper::$BattleTypesNames) ?> </h2>
<br />
<h3>WN8 und Schaden</h3>
<div>
    <canvas id="chart1" class="fixed-height-chart"></canvas>
</div>
<h3>Siege, Treffer, Abgewehrter Schaden und Überlebensrate (in Prozent)</h3>
<div>
    <canvas id="chart2" class="fixed-height-chart"></canvas>
</div>
<h3>Durchschnittliche Abschüsse, Basis Verteidigung und Aufklärung</h3>
<div>
    <canvas id="chart3" class="fixed-height-chart"></canvas>
</div>
<h3>Durchschnittliche EXP</h3>
<div>
    <canvas id="chart5" class="fixed-height-chart"></canvas>
</div>
<h3>Anzahl Gefechte</h3>
<div>
    <canvas id="chart4" class="fixed-height-chart"></canvas>
</div>

<?php
$label = "";
$data = [
    "chart1" => [
        "WN8" => "",
        "Schaden" => "",
    ],
    "chart2" => [
        "Siegrate %" => "",
        "Trefferrate %" => "",
        "Block %" => "",
        "Überleben %" => "",
    ],
    "chart3" => [
        "Abschüsse" => "",
        "Verteidigung" => "",
        "Aufklärung" => "",
    ],
    "chart4" => [
        "Gefechte" => "",
    ],
    "chart5" => [
        "XP" => "",
    ],
];

foreach ($stats as $stat) {
    $label .= '"' . $stat->date->format("d.m") . '",';

    $data["chart1"]["WN8"] .= WN8Helper::calcWN8($stat, $stat->tank) . ",";
    $data["chart1"]["Schaden"] .= $stat->damage / $stat->battle . ",";

    $data["chart2"]["Siegrate %"] .= $stat->win * 100 / $stat->battle . ",";
    $data["chart2"]["Trefferrate %"] .= $stat->hits * 100 / $stat->shots . ",";
    $data["chart2"]["Block %"] .= $stat->tanking . ",";
    $data["chart2"]["Überleben %"] .= $stat->survived * 100 / $stat->battle . ",";

    $data["chart3"]["Abschüsse"] .= $stat->frags / $stat->battle . ",";
    $data["chart3"]["Verteidigung"] .= $stat->droppedCapturePoints / $stat->battle . ",";
    $data["chart3"]["Aufklärung"] .= $stat->spotted / $stat->battle . ",";

    $data["chart4"]["Gefechte"] .= $stat->battle . ",";
    $data["chart5"]["XP"] .= $stat->xp / $stat->battle . ",";
}

$colors = [
    "rgb(18, 12, 110)",
    "rgb(0, 110, 15)",
    "rgb(66, 144, 222)",
    "rgb(20, 200, 70)",
]


?>
<script>
    <?php
    foreach ($data as $chart => $dataset):?>

    var <?= $chart ?> = new Chart(
        document.getElementById('<?= $chart ?>'),
        {
            type: 'line',
            data: {
                labels: [<?= $label ?>],
                datasets: [
                    <?php $i = 0 ?>
                    <?php foreach ($dataset as $n => $k):?>
                    {

                        label: '<?= $n ?>',
                        backgroundColor: '<?= $colors[$i] ?>',
                        borderColor: '<?= $colors[$i] ?>',
                        data: [<?= $k ?>],

                    },
                    <?php   $i++; endforeach;?>
                ]
            },
            options: {
                maintainAspectRatio: false,
            }
        }
    );
    <?= $chart ?>.height = 200;
    <?php endforeach; ?>
</script>
