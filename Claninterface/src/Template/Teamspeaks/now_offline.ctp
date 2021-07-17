<?php
/**
 * @var \App\View\AppView $this
 *
 * @var array $MembersOnline
 * */
?>

<?= $this->element('TeamspeakNav',['site' => "nowOffline"]) ?>
<h1>Live Verstöße</h1>
<table class="DataTable table table-sm table-striped">
    <thead>
    <tr>
        <th>Status</th>
        <th>Clan</th>
        <th>Spieler</th>
        <th>TS-Nick</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($MembersOnline as $member){?>
        <tr>

            <?php  if($member[0] == false){ ?>
                <td data-order='offline' data-search='offline'><i  class='text-danger bi bi-exclamation-diamond-fill'></i></td>
            <?php }else{?>
                <td data-order='online' data-search='online'> <i  class='text-success bi bi-check2-circle'></i></td>
            <?php }?>
            </td>
            <td><?= $member[1] ?></td>
            <td><?= $member[2] ?></td>
            <td><?= $member[3] ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<?= $this->element('DataTables', ['orderCol' => 1, 'order' => 'asc']) ?>
