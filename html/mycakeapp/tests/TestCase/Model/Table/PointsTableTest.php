<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PointsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PointsTable Test Case
 */
class PointsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PointsTable
     */
    public $Points;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Points',
        'app.Members',
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
        $config = TableRegistry::getTableLocator()->exists('Points') ? [] : ['className' => PointsTable::class];
        $this->Points = TableRegistry::getTableLocator()->get('Points', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Points);

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
