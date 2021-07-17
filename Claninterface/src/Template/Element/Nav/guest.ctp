<div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav mr-auto">
        <li class="nav-item">
            <?= $this->Html->link("Auszeit nehmen",['controller' => 'Inactives', 'action' => 'add', 'home'],["class"=>"nav-link"]) ?>
        </li>
        <li class="nav-item">
            <?= $this->Html->link("TS3 Rang",['controller' => 'Players', 'action' => 'tsRank'],["class"=>"nav-link"]) ?>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <?= $this->Html->link("Login",['controller' => 'Users', 'action' => 'login'],["class"=>"nav-link"]) ?>
        </li>
        <li class="nav-item">
            <?= $this->Html->link("Über & Rechtliches und Impressum",['controller' => 'pages',"action" =>"display", "impressum"],["class"=>"nav-link"]) ?>
        </li>
    </ul>
</div>
