<?php

return [
    /*
     * Information where to find the Teamspeak
     * - Host: IP or URL
     * - Port: (default 10011) Port of Query
     * - UID: UID of the virtual Server
     */
    'TeamspeakQueryConnection' => [
        'host' => '127.0.0.1',
        'port' => 10011,
        'uid' => '1',
    ],
    /*
     * Login Data for the TeamspeakQuery
     * - user: User
     * - pass: Password
     * - LoginName: Name Webinterface will use (extended: by  unique ID)
     */
    'TeamspeakQueryLogin' => [
        'user' => 'TeamspeakQueryLoginUser',
        'pass' => 'TeamspeakQueryLoginPasswd',
        'loginName' => 'WebInterface by LFS96'
    ],
    /*
     * Servergruppen die Admins sind und welche über ereignisse informiert werden sollen
     */
    'Teamspeak' => [
        'AdminGroups' => [1, 2, 3], //Admin können nicht gekickt/gebannt werden
        'NoticeGroups' => [4] // Werden durch das Claninterface direkt im TS informiert
    ],
    /*
     * Wargaming Developer API connection
     * - authkey: KEY
     * - expectedValues: URL to wn8exp.json
     * - lang: language of response
     * - server: url of server
     */
    "Wargaming" => [
        "authkey" => '0123456789abcdef0123456789abcdef',
        'expectedValues' => 'https://static.modxvm.com/wn8-data-exp/json/wn8exp.json',
        'lang' => 'de',
        'server' => 'api.worldoftanks.eu'
    ],
    /*
     * Einstellungen zu Spielerdaten
     */
    "PlayerData" => [
        "DelAfterDaysLeft" => 14, //Wann sollen Spielerdaten gelöscht werden.
    ]
];
