<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MeetingregistrationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MeetingregistrationsTable Test Case
 */
class MeetingregistrationsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MeetingregistrationsTable
     */
    public $Meetingregistrations;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Meetingregistrations',
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
        $config = TableRegistry::getTableLocator()->exists('Meetingregistrations') ? [] : ['className' => MeetingregistrationsTable::class];
        $this->Meetingregistrations = TableRegistry::getTableLocator()->get('Meetingregistrations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Meetingregistrations);

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
