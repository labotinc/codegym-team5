<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PointRatesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PointRatesTable Test Case
 */
class PointRatesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PointRatesTable
     */
    public $PointRates;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PointRates',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PointRates') ? [] : ['className' => PointRatesTable::class];
        $this->PointRates = TableRegistry::getTableLocator()->get('PointRates', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PointRates);

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
