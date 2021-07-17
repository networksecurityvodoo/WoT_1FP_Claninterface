<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MeetingparticipantsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MeetingparticipantsTable Test Case
 */
class MeetingparticipantsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MeetingparticipantsTable
     */
    public $Meetingparticipants;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Meetingparticipants',
        'app.Players',
        'app.Meetings',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Meetingparticipants') ? [] : ['className' => MeetingparticipantsTable::class];
        $this->Meetingparticipants = TableRegistry::getTableLocator()->get('Meetingparticipants', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Meetingparticipants);

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
