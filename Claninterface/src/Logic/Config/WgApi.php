<?php
namespace App\Logic\Config;

use Cake\Core\Configure;
use Wargaming\Api;

class WgApi
{
    public static function getWG_API (){
        $lang = Configure::read('Wargaming.lang');
        $server = Configure::read('Wargaming.server');
        $key = Configure::read('Wargaming.authkey');
        $server->setApplicationId($key);
        $api = new Api($lang, $server);



        $api->setSSLVerification(false);
        return $api;
    }
}
