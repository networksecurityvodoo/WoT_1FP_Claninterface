<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Logic\Helper\ClanRuleHelper;
use App\Logic\Helper\TeamSpeakQueryHelper;
use App\Logic\Helper\WarGamingHelper;
use App\Model\Table\ClansTable;

/**
 * Teamspeaks Controller
 *
 * @property \App\Model\Table\TeamspeaksTable $Teamspeaks
 *
 * @method \App\Model\Entity\Teamspeak[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TeamspeaksController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $TS_Online = $this->Teamspeaks->find("all")->contain(["Players", "Players.Clans", "Players.Ranks"])->innerJoinWith("Players.Clans")->where(["end >=" => "1970-01-02", "TIMESTAMPDIFF(SECOND, start, end) > " => "400"])->orderDesc("end")->limit(1000);
        $this->set('OfflineRecords', $TS_Online);

        $clans = $this->Teamspeaks->Players->Clans->find("all");
        $clans = $clans
            ->select(["Clan" => "Clans.short", "bis" => "max(Tokens.expires)"])
            ->leftJoinWith("Players")
            ->innerJoinWith("Players.Tokens")
            ->where(["Tokens.expires >" => $clans->func()->now()])
            ->group("Clans.id");
        $this->set('ClansTimeout', $clans);
    }

    public function nowOffline()
    {
        $CR = new ClanRuleHelper();
        $this->set("MembersOnline", $CR->checkTeamSpeak((new WarGamingHelper())->getOnlinePlayers(), (new TeamSpeakQueryHelper())->getClientlist()));

    }

    public function tsOnline()
    {
        $this->set("online", (new TeamSpeakQueryHelper())->getOnlinePlayersInfo());
    }

    /**
     * Delete method
     *
     * @param string|null $id Teamspeak id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $teamspeak = $this->Teamspeaks->get($id);
        if ($this->Teamspeaks->delete($teamspeak)) {
            $this->Flash->success(__('Der Eintrag über den Verstoß wurde gelöscht'));
        } else {
            $this->Flash->error(__('Der Eintrag über den Verstoß konnte nicht gelöscht werden. Bitte erneut versuchen.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function players()
    {
        $TS_Online = $this->Teamspeaks->find("all");
        $TS_Online
            ->select([
                "short" => "Clans.short",
                "nick" => "Players.nick",
                "sum" => $TS_Online->func()->sum("TIMESTAMPDIFF(SECOND, start, end)"),
                "count" => $TS_Online->func()->count("*")
            ])
            ->contain(["Players", "Players.Clans", "Players.Ranks"])
            ->innerJoinWith("Players.Clans")
            ->where(["end >=" => "1970-01-02", "TIMESTAMPDIFF(SECOND, start, end) > " => "400"])
            ->group("Players.id")
            ->orderDesc("Clans.short")
            ->orderDesc("Players.nick")->limit(1000);
        $this->set('OfflineRecords', $TS_Online);
    }

    /** Baned einen Spieler vom Server
     * @param string $uid CLient ID
     * @return \Cake\Http\Response|null letzte seite
     */
    public function ban($uid)
    {
        $this->request->allowMethod(['post', 'delete']);
        (new TeamSpeakQueryHelper())->banPlayerByUID(hex2bin($uid));
        return $this->redirect($this->referer());
    }

    /** Kickt einen Spieler vom Server
     * @param string $uid CLient ID
     * @return \Cake\Http\Response|null letzte seite
     */
    public function kick($uid)
    {
        $this->request->allowMethod(['post', 'delete']);
        (new TeamSpeakQueryHelper())->kickPlayerByUID(hex2bin($uid));
        return $this->redirect($this->referer());
    }

    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');
        $action = strtolower($action);
        $pl = $this->permissionLevel;

        if ($pl >= 8 && !in_array($action, ["kick", "ban"])) {
            return true;
        }

        if ($pl >= 10) {
            return true;
        }
        return false;
    }

    public function initialize()
    {
        parent::initialize();
    }
}
