<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SlideshowPicturesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SlideshowPicturesTable Test Case
 */
class SlideshowPicturesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SlideshowPicturesTable
     */
    public $SlideshowPictures;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.SlideshowPictures',
        'app.Movies',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('SlideshowPictures') ? [] : ['className' => SlideshowPicturesTable::class];
        $this->SlideshowPictures = TableRegistry::getTableLocator()->get('SlideshowPictures', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SlideshowPictures);

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
