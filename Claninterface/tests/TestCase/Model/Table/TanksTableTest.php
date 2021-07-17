<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TanksTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TanksTable Test Case
 */
class TanksTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TanksTable
     */
    public $Tanks;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Tanks',
        'app.TankTypes',
        'app.Statistics',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Tanks') ? [] : ['className' => TanksTable::class];
        $this->Tanks = TableRegistry::getTableLocator()->get('Tanks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Tanks);

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
