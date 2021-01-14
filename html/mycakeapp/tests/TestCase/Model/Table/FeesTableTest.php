<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FeesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FeesTable Test Case
 */
class FeesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FeesTable
     */
    public $Fees;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Fees',
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
        $config = TableRegistry::getTableLocator()->exists('Fees') ? [] : ['className' => FeesTable::class];
        $this->Fees = TableRegistry::getTableLocator()->get('Fees', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Fees);

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
