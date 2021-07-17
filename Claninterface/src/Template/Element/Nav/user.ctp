<div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <?= $this->Html->link("Mein Konto",['controller' => 'Users', 'action' => 'Dashboard'],["class"=>"nav-link"]) ?>
                <li class="nav-item">
                    <?= $this->Html->link("Auszeit nehmen",['controller' => 'Inactives', 'action' => 'add', 'home'],["class"=>"nav-link"]) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link("TS3 Rang",['controller' => 'Players', 'action' => 'tsRank'],["class"=>"nav-link"]) ?>
                </li>

            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?= $auth["name"] ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">

                        <?= $this->Html->link("Passwort ändern",['controller' => 'Users', 'action' => 'newpass'],["class"=>"dropdown-item"]) ?>
                        <?= $this->Html->link("Abmelden",['controller' => 'Users', 'action' => 'logout'],["class"=>"dropdown-item"]) ?>
                        <?= $this->Html->link("Über & Rechtliches und Impressum",['controller' => 'pages',"action" =>"display", "impressum"],["class"=>"dropdown-item"]) ?>
                    </div>

                </li>
            </ul>
        </div>
