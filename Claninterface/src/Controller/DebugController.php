<?php


namespace App\Controller;


use App\Logic\Helper\WarGamingHelper;

class DebugController extends AppController
{

    public function test(){
        $wg = new WarGamingHelper();
        $acc = $wg->searchPlayer("LFS96");
        dump($acc);

    }
    public function initialize()
    {
        parent::initialize();
        // Add the 'add' action to the allowed actions list.
       $this->Auth->allow(['test']);
    }
}
