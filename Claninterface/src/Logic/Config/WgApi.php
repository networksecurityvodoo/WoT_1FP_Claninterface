<?php
namespace App\Logic\Config;

use Cake\Core\Configure;
use Wargaming\Language\EN as EnglishLanguage;
use Wargaming\Server\EU as EuropeanServer;
use Wargaming\API;

class WgApi
{
    public static function getWG_API (){
        $key = Configure::read('Wargaming.authkey');
        $lang = new EnglishLanguage();
        $server = new EuropeanServer($key);
        $api = new API($lang, $server);
        $api->setSSLVerification(false);
        return $api;
    }
}
