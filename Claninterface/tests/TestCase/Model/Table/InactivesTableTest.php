<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InactivesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InactivesTable Test Case
 */
class InactivesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\InactivesTable
     */
    public $Inactives;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Inactives',
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
        $config = TableRegistry::getTableLocator()->exists('Inactives') ? [] : ['className' => InactivesTable::class];
        $this->Inactives = TableRegistry::getTableLocator()->get('Inactives', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Inactives);

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
