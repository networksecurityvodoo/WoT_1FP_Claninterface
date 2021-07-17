<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RanksTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RanksTable Test Case
 */
class RanksTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RanksTable
     */
    public $Ranks;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Ranks',
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
        $config = TableRegistry::getTableLocator()->exists('Ranks') ? [] : ['className' => RanksTable::class];
        $this->Ranks = TableRegistry::getTableLocator()->get('Ranks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Ranks);

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
