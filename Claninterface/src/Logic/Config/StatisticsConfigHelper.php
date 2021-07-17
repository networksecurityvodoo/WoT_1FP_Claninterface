<?php


namespace App\Logic\Config;


class StatisticsConfigHelper
{
    public static $BattleTypes = ["all", "globalmap", "stronghold_skirmish", "stronghold_defense"];
    public static $FieldsList = "account_id,in_garage,tank_id,all,globalmap,stronghold_skirmish,stronghold_defense";

    //selbe Reihenfolge wie $BattleTypes
    public static $BattleTypesNames = [
        "Zufallsgefechte" => "all",
        "Clan Wars" => "globalmap",
        "Festung" => "stronghold_skirmish",
        "Vorstoß" => "stronghold_defense"
    ];
}
