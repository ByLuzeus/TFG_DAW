<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UserconfigsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UserconfigsTable Test Case
 */
class UserconfigsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\UserconfigsTable
     */
    protected $Userconfigs;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Userconfigs',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Userconfigs') ? [] : ['className' => UserconfigsTable::class];
        $this->Userconfigs = $this->getTableLocator()->get('Userconfigs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Userconfigs);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\UserconfigsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
