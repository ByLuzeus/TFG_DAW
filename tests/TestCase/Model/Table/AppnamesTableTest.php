<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AppnamesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AppnamesTable Test Case
 */
class AppnamesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AppnamesTable
     */
    protected $Appnames;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Appnames',
        'app.Appdatas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Appnames') ? [] : ['className' => AppnamesTable::class];
        $this->Appnames = $this->getTableLocator()->get('Appnames', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Appnames);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\AppnamesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\AppnamesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
