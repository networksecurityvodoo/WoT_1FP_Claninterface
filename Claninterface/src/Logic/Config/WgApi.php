<?php
namespace App\Logic\Config;

use Cake\Core\Configure;
use Cake\View\Helper\UrlHelper;
use const Wargaming\SERVER_EU;
use const Wargaming\LANGUAGE_DEUTSCH;
use Wargaming\API;

class WgApi
{
    public static function getWG_API (){
        $key = Configure::read('Wargaming.authkey');
        $lang = Configure::read('Wargaming.lang');
        $server = Configure::read('Wargaming.server');

        return new API($key, $lang, $server);
    }
}
