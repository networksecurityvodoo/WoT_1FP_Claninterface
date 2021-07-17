<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TanktypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TanktypesTable Test Case
 */
class TanktypesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TanktypesTable
     */
    public $Tanktypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Tanktypes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Tanktypes') ? [] : ['className' => TanktypesTable::class];
        $this->Tanktypes = TableRegistry::getTableLocator()->get('Tanktypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Tanktypes);

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
