<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TheatersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TheatersTable Test Case
 */
class TheatersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TheatersTable
     */
    public $Theaters;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Theaters',
        'app.Schedules',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Theaters') ? [] : ['className' => TheatersTable::class];
        $this->Theaters = TableRegistry::getTableLocator()->get('Theaters', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Theaters);

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
