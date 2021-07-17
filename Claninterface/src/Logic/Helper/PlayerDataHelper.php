<?php


namespace App\Logic\Helper;


use App\Logic\Config\StatisticsConfigHelper;
use App\Logic\Config\WgApi;
use App\Model\Entity\Player;
use App\Model\Table\PlayersTable;
use App\Model\Table\RawsTable;
use App\Model\Table\StatisticsTable;
use Cake\Console\ConsoleIo;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class PlayerDataHelper
{
    private $api = null;
    private $wn8expectedValues = null;
    private $tanktypes = null;

    public function __construct()
    {
        $this->api = WgApi::getWG_API();

    }

    /**
     * Importiert die Statistischen Daten aller Spieler eines Clans
     * @param int $clan WG-Clan id
     * @param ConsoleIo|null $io
     * @return int
     */
    public function importPlayerStatistic($clan, $io = null )
    {
        /**
         * @var PlayersTable $PlayerTables
         * @var RawsTable $RawTables
         * @var StatisticsTable $StatisticTables
         */

        $PlayerTables = TableRegistry::getTableLocator()->get('Players');
        $StatisticTables = TableRegistry::getTableLocator()->get('Statistics');

        $players = $PlayerTables->find("all")->where(["clan_id" => $clan]);
        $counter = 0;

        $start = microtime(true);
        /** @var Player $player */
        foreach ($players as $player) {
            //Download  from  WG-API
            try {
                $stat = $this->api->get("wot/tanks/stats/", ["account_id" => $player->id, "fields" => StatisticsConfigHelper::$FieldsList]);

                foreach ($stat->{$player->id} as $tankStat) {
                    $data = array();
                    foreach (StatisticsConfigHelper::$BattleTypes as $battleType) {
                        $battleTypeStat = $tankStat->$battleType;
                        if ($battleTypeStat->battles) {

                            $statDate = time() - (24 * 60 * 60);

                            if (time() >= strtotime("04:00:00")) {
                                $statDate = time();
                            }

                            $arr = array(
                                //basis
                                "player_id" => $player->id,
                                "tank_id" => $tankStat->tank_id,
                                "date" => date("Y-m-d", $statDate),
                                "battletype" => $battleType,

                                //WN8
                                "damage" => $battleTypeStat->damage_dealt,
                                "spotted" => $battleTypeStat->spotted,
                                "frags" => $battleTypeStat->frags,
                                "droppedCapturePoints" => $battleTypeStat->dropped_capture_points,
                                "battle" => $battleTypeStat->battles,
                                "win" => $battleTypeStat->wins,

                                //erweitert
                                "shots" => $battleTypeStat->shots,
                                "hits" => $battleTypeStat->hits,
                                "xp" => $battleTypeStat->xp,
                                "survived" => $battleTypeStat->survived_battles,
                                "tanking" => intval($battleTypeStat->tanking_factor * 100),

                            );
                            $data [] = $arr;
                            $counter++;
                        }
                    }

                    $statistic = $StatisticTables->newEntities($data);
                    $StatisticTables->saveMany($statistic, ['checkRules' => false, 'atomic' => false]);

                }
            } catch (\Exception $e) {
                if($io == null) {
                    echo $e->getMessage();
                }else{
                    $io->out($e->getMessage());
                }
            }
        }

        $time_elapsed_secs = microtime(true) - $start;
        //  echo $time_elapsed_secs;
        return $counter;
    }

    public function cleanUpPlayer()
    {

        $out = "";

        $PlayersTable = TableRegistry::getTableLocator()->get('Players');
        $players = $PlayersTable->find("all")->where(function ($exp, $q) {
            return $exp->isNull('clan_id');
        });

        $clan_array = WarGamingHelper::getClanListArray();

        /**
         * @var Player $player
         */
        foreach ($players as $player) {
            $resp = $this->api->get("wot/clans/memberhistory/", ["account_id" => $player->id]);
            $data = $resp->{$player->id};


            $left = 0;
            foreach ($data as $clan_hist) {
                if (in_array($clan_hist->clan_id, $clan_array)) {
                    if ($left <= $clan_hist->left_at) {
                        $left = $clan_hist->left_at;
                    }
                }
            }
            $days = Configure::read('PlayerData.DelAfterDaysLeft');

            $diff = floor((time() - $left) / (24 * 60 * 60));
            if ($diff >= $days) {
                $out .= "Spieler '{$player->nick}' wird gelöscht, ist vor $diff Tagen am " . date("d.m.Y", $left) . " ausgetreten" . PHP_EOL;
                $PlayersTable->delete($player);
            } else {
                $out .= "Spieler '{$player->nick}' ist erst vor $diff Tagen ausgetreten" . PHP_EOL;
            }
        }
        return $out;
    }
}
