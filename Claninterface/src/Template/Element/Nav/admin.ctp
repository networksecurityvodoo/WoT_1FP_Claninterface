<div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <?= $this->Html->link("Clans",['controller' => 'Clans', 'action' => 'index'],["class"=>"nav-link"]) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link("Teamspeak",['controller' => 'Teamspeaks', 'action' => 'index'],["class"=>"nav-link"]) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link("Abmeldungen",['controller' => 'Inactives', 'action' => 'index'],["class"=>"nav-link"]) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link("Veranstaltung",['controller' => 'Meetings', 'action' => 'index'],["class"=>"nav-link"]) ?>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       Mehr
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <?= $this->Html->link("Panzer",['controller' => 'Tanks', 'action' => 'index'],["class"=>"dropdown-item"]) ?>
                        <?= $this->Html->link("Ränge",['controller' => 'Ranks', 'action' => 'index'],["class"=>"dropdown-item"]) ?>
                        <?= $this->Html->link("TS3 Rang",['controller' => 'Players', 'action' => 'tsRank'],["class"=>"dropdown-item"]) ?>
                    </div>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?= $auth["name"] ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <?= $this->Html->link("Mein Konto",['controller' => 'Users', 'action' => 'Dashboard'],["class"=>"dropdown-item"]) ?>
                        <?= $this->Html->link("Passwort ändern",['controller' => 'Users', 'action' => 'newpass'],["class"=>"dropdown-item"]) ?>
                        <?= $this->Html->link("Abmelden",['controller' => 'Users', 'action' => 'logout'],["class"=>"dropdown-item"]) ?>
                        <?= $this->Html->link("Über & Rechtliches und Impressum",['controller' => 'pages',"action" =>"display", "impressum"],["class"=>"dropdown-item"]) ?>
                    </div>
                </li>
            </ul>
        </div>
