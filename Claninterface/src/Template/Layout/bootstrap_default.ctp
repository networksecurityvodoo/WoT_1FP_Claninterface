<?php
/**
 * Created by PhpStorm.
 * User: fHarmsen
 * Date: 20.02.2019
 * Time: 09:36
 *
 * @var \App\View\AppView $this
 * @var int $permissionLevel
 */


use Cake\Core\Configure;

$lang = Configure::read('App.language');

/**
 * Default `flash` block.
 */
if (!$this->fetch('tb_flash')) {
    $this->start('tb_flash');
    if (isset($this->Flash))
        echo $this->Flash->render();
    $this->end();
}
if (!$this->fetch('tb_breadcrumb')) {
    $this->start('tb_breadcrumb');
    if (isset($this->Breadcrumbs)) {
        echo "<div class='mps-bread'>";
        echo $this->Breadcrumbs->render();
        echo "</div>";
    }
    $this->end();
}


/**
 * Prepend `meta` block with `author` and `favicon`.
 */
$this->prepend('meta', $this->Html->meta('author', null, ['name' => 'author', 'content' => Configure::read('App.author')]));
$this->prepend('meta', $this->Html->meta('favicon.ico', '/favicon.ico', ['type' => 'icon']));
$this->prepend('meta', $this->Html->meta(array('name' => 'robots', 'content' => 'noindex, nofollow'), null, array('inline' => false)));


$isAuth = ($auth != null);
$isAdmin = true;

$isOnlyPlayer = false;


$container_class = "container";
if(isset($container)){
    $container_class  = $container;
}

?>
<!DOCTYPE html>
<head lang="<?= $lang ?>" class="no-js">
    <?= $this->Html->charset() ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1">
    <title><?= $this->fetch('title') ?></title>
    <?= $this->fetch('meta') ?>

    <?= $this->Html->css('bootstrap4/bootstrap.min.css'); ?>
    <?= $this->Html->css('jquery-ui.min.css'); ?>
    <?= $this->Html->css("bootstrap-icons.min.css"); ?>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">
    <?= $this->Html->css("default.min.css"); ?>
    <?= $this->Html->css("font_awesome/all.min.css"); ?>
    <?= $this->fetch('css'); ?>

    <?= $this->Html->script('jquery-3.5.1.min.js') ?>
    <?= $this->Html->script('popper.min.js') ?>
    <?= $this->Html->script('bootstrap4/bootstrap.min.js') ?>
    <?= $this->Html->script('font_awesome/all.min.js') ?>
    <script src='https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js'></script>
    <script src='https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>var _tooltip = jQuery.fn.tooltip;</script>
    <?= $this->Html->script('jquery-ui.min.js') ?>
    <script>jQuery.fn.tooltip = _tooltip;</script>
    <?= $this->fetch('js'); ?>
<body>
<nav class="navbar navbar-dark bg-dark navbar-expand-md">
    <div class="container">
        <a class="navbar-brand" href="#">Clan Interface</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <?php if ($isAuth == false): ?>
            <?= $this->element('Nav/guest', []) ?>
        <?php endif; ?>
        <?php if ($isAuth == true): ?>
            <?php if ($permissionLevel > 5): ?>
                <?= $this->element('Nav/admin', []) ?>
            <?php endif; ?>
            <?php if ($permissionLevel == 5): ?>
                <?= $this->element('Nav/fk', []) ?>
            <?php endif; ?>
            <?php if ($permissionLevel < 5): ?>
                <?= $this->element('Nav/user', []) ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</nav>
<div class="<?= $container_class ?>">
    <br/>
    <?= $this->fetch('tb_breadcrumb'); ?>

    <?= $this->fetch('tb_flash'); ?>

    <?= $this->fetch('content'); ?>
    <br/>
    <?= $this->fetch('tb_footer'); ?>
</div>
<span class="copyright-lfs96">by LFS96
    <?= $this->Html->link('<i class="bi bi-github"></i>', 'https://github.com/LFS96/WoT_1FP_Claninterface', ["escape" => false, "target" => "_blank"]) ?>
    <?= $this->Html->link('<i class="bi bi-telegram"></i>', 'https://t.me/FabiGothic', ["escape" => false, "target" => "_blank"]) ?>
    <?= $this->Html->link('<i class="bi bi-instagram"></i>', 'https://instagram.com/fabigothic/', ["escape" => false, "target" => "_blank"]) ?><br/>
    <a rel="license" href="https://www.gnu.org/licenses/gpl-3.0.en.html" target="_blank"><img
            alt="GNU GENERAL PUBLIC LICENSE" style="border-width:0"
            src="https://upload.wikimedia.org/wikipedia/commons/9/93/GPLv3_Logo.svg"
            title="Dieses Werk ist lizenziert unter einer GNU GENERAL PUBLIC LICENSE"/></a>
</span>
<?= $this->fetch('scriptBottom'); ?>
<script>
    $(document).ready(function (){$('[data-toggle="tooltip"]').tooltip();});
</script>
</body>
</html>
