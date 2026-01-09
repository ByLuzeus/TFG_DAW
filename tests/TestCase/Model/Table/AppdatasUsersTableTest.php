<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AppdatasUsersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AppdatasUsersTable Test Case
 */
class AppdatasUsersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AppdatasUsersTable
     */
    protected $AppdatasUsers;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.AppdatasUsers',
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
        $config = $this->getTableLocator()->exists('AppdatasUsers') ? [] : ['className' => AppdatasUsersTable::class];
        $this->AppdatasUsers = $this->getTableLocator()->get('AppdatasUsers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->AppdatasUsers);

        parent::tearDown();
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\AppdatasUsersTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
