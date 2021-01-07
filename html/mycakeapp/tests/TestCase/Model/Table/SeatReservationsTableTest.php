<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SeatReservationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SeatReservationsTable Test Case
 */
class SeatReservationsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SeatReservationsTable
     */
    public $SeatReservations;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.SeatReservations',
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
        $config = TableRegistry::getTableLocator()->exists('SeatReservations') ? [] : ['className' => SeatReservationsTable::class];
        $this->SeatReservations = TableRegistry::getTableLocator()->get('SeatReservations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SeatReservations);

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
