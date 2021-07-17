<!DOCTYPE html>
<html lang="de">
<head>
    <meta http-equiv="Content-Type" content="text/html charset=UTF-8" />
    <?php if($title): ?>
        <title><?= $title; ?></title>
    <?php endif; ?>
    <?= $this->element("email/html/DefaultStyle") ?>
</head>
<body>
<!--[if mso]>

<table border="0" style="border: none;border-collapse: collapse;"><tr><td class="td-full" border="0" style="border: none;border-collapse: collapse;">
    <font size="4">
<![endif]-->
<div class="container "style="max-width: 750px;margin: 0;color: black;font-family: Arial,'Segoe UI','Helvetica Neue',sans-serif;font-size: 13px;">

<?= $this->fetch('content') ?>
    <br />
    Grüße <br />
    Ihr WoT-Claninterface<br />
    <br />
    <small>Sie erhalten diese  E-Mail, da Sie ein Konto im WoT-Claninterface von LFS96 haben. </small><br />





</div>
<!--[if mso]>
</font>
</td></tr></table>
<![endif]-->
</body>
</html>
