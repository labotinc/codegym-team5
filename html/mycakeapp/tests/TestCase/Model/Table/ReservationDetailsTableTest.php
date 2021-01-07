<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ReservationDetailsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ReservationDetailsTable Test Case
 */
class ReservationDetailsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ReservationDetailsTable
     */
    public $ReservationDetails;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ReservationDetails',
        'app.Members',
        'app.Schedules',
        'app.Fees',
        'app.Discounts',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ReservationDetails') ? [] : ['className' => ReservationDetailsTable::class];
        $this->ReservationDetails = TableRegistry::getTableLocator()->get('ReservationDetails', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ReservationDetails);

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
