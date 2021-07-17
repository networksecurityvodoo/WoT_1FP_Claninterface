<?php


namespace App\Logic\Helper;


use App\Model\Entity\Statistic;
use Cake\ORM\TableRegistry;

class WN8Helper
{

    /**
     * @param $player_id
     * @param $battletype
     * @param null $date
     * @return float|int
     */
    public static function getPlayerWN8($player_id, $battletype, $date= null ){
        if($date == null){
            $date = date("Y-m-d");
        }

        $StatisticTables = TableRegistry::getTableLocator()->get('Statistics');
        $stats = $StatisticTables->find("all")->where(["player_id"=>$player_id, "battletype"=>$battletype, "date"=>$date])->contain(["tanks"])->orderAsc("tanks.name");
        $wn8 = 0;
        $battles = 0;
        /** @var Statistic $stat */

        echo "<table>";
        echo $stats->count();
        foreach ($stats as $stat){
            $battles += $stat->battle;
            $wn =self::calcWN8($stat);
            echo "<tr><td>".$stat->Tanks["name"]."</td><td>".round($wn,2)."</td><td>{$stat->battle}</td></tr>";
            $wn8 += ( $wn*$stat->battle );
        }
        echo $battles;
        echo "</table>";
        return $wn8 /$battles;
    }

    /**
     * @param Statistic $stat
     * @return float|int
     */
    public static function calcWN8(Statistic $stat,$tank =  false){
        if(!$tank){
            $tank =  $stat->Tanks;
        }


        $DAMAGE =  $stat->damage   / $stat->battle  ;
        $SPOT =    $stat->spotted  / $stat->battle  ;
        $FRAG =    $stat->frags    / $stat->battle  ;
        $DEF =     $stat->droppedCapturePoints / $stat->battle  ;
        $WIN =     ($stat->win *100)      / $stat->battle   ;
      //  echo ("|DMG :".$DAMAGE."|SPOT :".$SPOT."|FRAG :".$FRAG."|DEF :".$DEF."|WIN :".$WIN );

        //Step 1
        $rDAMAGE =  $DAMAGE / $tank["expDamage"] ;
        $rSPOT =    $SPOT   / $tank["expSpot"] ;
        $rFRAG =    $FRAG   / $tank["expFrag"] ;
        $rDEF =     $DEF    / $tank["expDef"] ;
        $rWIN =     $WIN    / $tank["expWinRate"] ;
      //  echo ("|rDMG :".$rDAMAGE."|rSPOT :".$rSPOT."|rFRAG :".$rFRAG."|rDEF :".$rDEF."|rWIN :".$rWIN );

        //Step2
        $rWINc      = max(0, ($rWIN - 0.71)     / (1 - 0.71) );
        $rDAMAGEc   = max(0, ($rDAMAGE - 0.22)  / (1 - 0.22) );
        $rFRAGc     = max(0, min($rDAMAGEc + 0.2, ($rFRAG - 0.12) / (1 - 0.12))) ;
        $rSPOTc     = max(0, min($rDAMAGEc + 0.1, ($rSPOT - 0.38) / (1 - 0.38)));
        $rDEFc      = max(0, min($rDAMAGEc + 0.1, ($rDEF - 0.10)  / (1 - 0.10)));
       // echo ("|rWINc :".$rWINc."|rDAMAGEc :".$rDAMAGEc."|rFRAGc :".$rFRAGc."|rSPOTc :".$rSPOTc."|rDEFc :".$rDEFc );

        return 980*$rDAMAGEc + 210*$rDAMAGEc*$rFRAGc + 155*$rFRAGc*$rSPOTc + 75*$rDEFc*$rFRAGc + 145*MIN(1.8,$rWINc);
    }

    public static function WnColor($n){
        $class = "wn8 wn8-black";
        if($n >= 500){
            $class = "wn8 wn8-red";
        }
        if($n >= 700){
            $class = "wn8 wn8-orange";
        }
        if($n >= 900){
            $class = "wn8 wn8-yellow";
        }
        if($n >= 1100){
            $class = "wn8 wn8-green";
        }
        if($n >= 1350){
            $class = "wn8 wn8-darkgreen";
        }
        if($n >= 1550){
            $class = "wn8 wn8-blue";
        }
        if($n >= 1850){
            $class = "wn8 wn8-violett";
        }
        if($n >= 2050){
            $class = "wn8 wn8-purple";
        }

        return $class;
    }

    public static function SiegColor($n){
        $class = "wn8 wn8-black";
        if($n >= 45){
            $class = "wn8 wn8-red";
        }
        if($n >= 47){
            $class = "wn8 wn8-orange";
        }
        if($n >= 49){
            $class = "wn8 wn8-yellow";
        }
        if($n >= 52){
            $class = "wn8 wn8-green";
        }
        if($n >= 54){
            $class = "wn8 wn8-darkgreen";
        }
        if($n >= 56){
            $class = "wn8 wn8-blue";
        }
        if($n >= 60){
            $class = "wn8 wn8-violett";
        }
        if($n >= 65){
            $class = "wn8 wn8-purple";
        }

        return $class;
    }

}
