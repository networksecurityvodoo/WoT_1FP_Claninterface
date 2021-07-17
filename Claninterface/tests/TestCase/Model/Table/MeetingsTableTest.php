<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MeetingsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MeetingsTable Test Case
 */
class MeetingsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MeetingsTable
     */
    public $Meetings;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Meetings',
        'app.Clans',
        'app.Meetingparticipants',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Meetings') ? [] : ['className' => MeetingsTable::class];
        $this->Meetings = TableRegistry::getTableLocator()->get('Meetings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Meetings);

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
