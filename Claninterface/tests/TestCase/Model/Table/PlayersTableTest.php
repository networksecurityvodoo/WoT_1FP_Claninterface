<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PlayersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PlayersTable Test Case
 */
class PlayersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PlayersTable
     */
    public $Players;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Players',
        'app.Clans',
        'app.Ranks',
        'app.Inactives',
        'app.Statistics',
        'app.Teamspeaks',
        'app.Tokens',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Players') ? [] : ['className' => PlayersTable::class];
        $this->Players = TableRegistry::getTableLocator()->get('Players', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Players);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
