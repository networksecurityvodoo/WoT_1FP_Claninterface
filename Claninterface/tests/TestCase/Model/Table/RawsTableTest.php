<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RawsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RawsTable Test Case
 */
class RawsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RawsTable
     */
    public $Raws;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Raws',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Raws') ? [] : ['className' => RawsTable::class];
        $this->Raws = TableRegistry::getTableLocator()->get('Raws', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Raws);

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
