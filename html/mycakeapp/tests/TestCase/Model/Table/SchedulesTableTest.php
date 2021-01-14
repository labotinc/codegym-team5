<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SchedulesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SchedulesTable Test Case
 */
class SchedulesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SchedulesTable
     */
    public $Schedules;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Schedules',
        'app.Movies',
        'app.Theaters',
        'app.Payments',
        'app.Points',
        'app.ReservationDetails',
        'app.SeatReservations',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Schedules') ? [] : ['className' => SchedulesTable::class];
        $this->Schedules = TableRegistry::getTableLocator()->get('Schedules', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Schedules);

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
