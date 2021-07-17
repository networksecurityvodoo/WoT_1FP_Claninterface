<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tank[]|\Cake\Collection\CollectionInterface $tanks
 */

use App\Logic\Helper\StringHelper;

?>

    <h1>Panzer im Spiel mit WN8 Statistik</h1>

    <?php if($permissionLevel >= 8){ echo$this->Html->link('<i class="bi bi-cloud-download"></i> Import anstoßen',["action"=>"import"],["class" =>"btn btn-dark btn-sm","escape"=>false])."<br />";}?>
<br />


    <table class="DataTable table table-sm table-striped">
        <thead>
            <tr>
                <th> Land</th>
                <th> Name</th>
                <th> Tier</th>
                <th> Typ</th>
                <th> Prem</th>
                <th> Decap</th>
                <th> Kills</th>
                <th> Spot</th>
                <th> Damage</th>
                <th> WinRate</th>
                <th><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tanks as $tank): ?>
            <tr>
                <td data-sort="<?= $tank->nation ?>"><?= $this->Html->image("flags/". $tank->nation.".png",["height"=>"35"])?></td>
                <th><?= h($tank->name) ?></th>
                <td data-sort="<?= $tank->tier ?>"><?= StringHelper::numberToRomanRepresentation($tank->tier) ?></td>
                <td data-sort="<?= $tank->tanktype["name"] ?>"><?= $this->Html->image("tanktypes/". $tank->tanktype["name"].".png",["height"=>"35"])?></td>
                <td data-sort="<?= $tank->premium?1:0 ?>"><?= $this->Html->image("tanktypes/". ($tank->premium?"premium":"tank").".png",["height"=>"35"])?></td>
                <td data-sort="<?= $tank->expDef ?>"><?= $this->Number->format($tank->expDef  , ["locale" => 'de_DE']) ?></td>
                <td data-sort="<?= $tank->expFrag ?>"><?= $this->Number->format($tank->expFrag , ["locale" => 'de_DE']) ?></td>
                <td data-sort="<?= $tank->expSpot ?>"><?= $this->Number->format($tank->expSpot , ["locale" => 'de_DE']) ?></td>
                <td data-sort="<?= $tank->expDamage ?>"><?= $this->Number->format($tank->expDamage , ["locale" => 'de_DE']) ?></td>
                <td data-sort="<?= $tank->expWinRate ?>"><?= $this->Number->format($tank->expWinRate, ["locale" => 'de_DE']) ?></td>
                <td>
                    <?= $this->Html->link('<i class="bi bi-eye-fill"></i>', ['action' => 'view', $tank->id],["class"=>"btn btn-primary btn-sm", "escape"=>false]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->element('DataTables', ['orderCol' => 2, 'order' => 'desc']) ?>
