<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ClansTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ClansTable Test Case
 */
class ClansTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ClansTable
     */
    public $Clans;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Clans',
        'app.Players',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Clans') ? [] : ['className' => ClansTable::class];
        $this->Clans = TableRegistry::getTableLocator()->get('Clans', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Clans);

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
}
