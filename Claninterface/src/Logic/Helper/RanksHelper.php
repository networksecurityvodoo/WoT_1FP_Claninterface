<?php


namespace App\Logic\Helper;


use App\Model\Table\RanksTable;
use Cake\ORM\TableRegistry;

class RanksHelper
{
    public static function string2rank($str){
        /**
         * @var RanksTable $RanksTable
         */
        $RanksTable = TableRegistry::getTableLocator()->get('Ranks');

        $ranks = $RanksTable->find("all")->where(["name"=>$str]);

        if($ranks->count()){
            $rank =$ranks->first();
            return $rank->id;
        }else{

            return false;
        }
    }

    public static function days2rank($days){
        $rank = [
            "name" =>"Panzerschütze",
            "img" => "schuetze.png"
        ];
        if($days >= 30){
            $rank = [
                "name" =>"Gefreiter",
                "img" => "gefreiter.png"
            ];
        }
        if($days >= 60){
            $rank = [
                "name" =>"Obergefreiter",
                "img" => "obergefreiter.png"
            ];
        }
        if($days >= 100){
            $rank = [
                "name" =>"Hauptgefreiter",
                "img" => "hauptgefreiter.png"
            ];
        }
        if($days >= 200){
            $rank = [
                "name" =>"Unteroffizier",
                "img" => "unteroffizier.png"
            ];
        }
        if($days >= 350){
            $rank = [
                "name" =>"Stabsunteroffizier",
                "img" => "stabsunteroffizier.png"
            ];
        }
        if($days >= 500){
            $rank = [
                "name" =>"Feldwebel",
                "img" => "feldwebel.png"
            ];
        }
        if($days >= 1000){
            $rank = [
                "name" =>"Oberfeldwebel",
                "img" => "oberfeldwebel.png"
            ];
        }
        if($days >= 1500){
            $rank = [
                "name" =>"Hauptfeldwebel",
                "img" => "hauptfeldwebel.png"
            ];
        }
        if($days >= 2000){
            $rank = [
                "name" =>"Stabsfeldwebel",
                "img" => "stabsfeldwebel.png"
            ];
        }
        if($days >= 2499){
            $rank = [
                "name" =>"Oberstabsfeldwebel",
                "img" => "oberstabsfeldwebel.png"
            ];
        }
        return $rank;
    }





}
