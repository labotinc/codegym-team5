<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DiscountsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DiscountsTable Test Case
 */
class DiscountsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DiscountsTable
     */
    public $Discounts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Discounts',
        'app.ReservationDetails',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Discounts') ? [] : ['className' => DiscountsTable::class];
        $this->Discounts = TableRegistry::getTableLocator()->get('Discounts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Discounts);

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
