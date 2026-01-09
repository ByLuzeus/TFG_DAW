<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\NotificationsUsersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\NotificationsUsersTable Test Case
 */
class NotificationsUsersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\NotificationsUsersTable
     */
    protected $NotificationsUsers;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.NotificationsUsers',
        'app.Notifications',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('NotificationsUsers') ? [] : ['className' => NotificationsUsersTable::class];
        $this->NotificationsUsers = $this->getTableLocator()->get('NotificationsUsers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->NotificationsUsers);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\NotificationsUsersTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\NotificationsUsersTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
