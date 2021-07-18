<?php
/**
 * @var \App\Model\Entity\Meeting[] $Meetings
 * @var array $Players
 * @var \App\Model\Entity\Clan $Clan
 */

?>
<?= $this->Html->link(__('<i class="bi bi-chevron-left"></i> zurück'), ['action' => 'index'], ["class" => "btn btn-dark btn-sm", "escape" => false]) ?>&nbsp;

<h4>Teilname Zusammenfassung für <?= $Clan->short ?></h4>

<i class="text-secondary far fa-times-circle"></i> Nicht im TS3-Server
 | <i class="text-success bi bi-check-circle-fill"></i> Am TS3-Server und im Spiel
 | <i class='text-danger bi bi-exclamation-diamond-fill'></i> Am TS3-Server aber nicht im Spiel

<table class="table table-striped table-sm">
    <thead>
    <tr>
        <th></th>
        <?php foreach($Meetings as $meeting): ?>
            <th><?= $meeting->name ?> (<?= $meeting->date->format("d.m.y")?>)</th>
        <?php endforeach; ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach($Players as $nick => $m): ?>
    <tr>
        <th><?= $nick ?></th>
        <?php foreach($m as $meeting): ?>
            <td>
                <?php
                    if($meeting == null){
                        echo '<i class="text-secondary far fa-times-circle"></i>';
                    }else{
                        echo  $meeting->wot?'<i class="text-success bi bi-check-circle-fill"></i>':"<i class='text-danger bi bi-exclamation-diamond-fill'></i>";
                    }
                ?>
            </td>
        <?php endforeach; ?>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<br />
<br />

