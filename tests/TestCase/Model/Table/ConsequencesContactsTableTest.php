<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ConsequencesContactsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ConsequencesContactsTable Test Case
 */
class ConsequencesContactsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ConsequencesContactsTable
     */
    protected $ConsequencesContacts;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.ConsequencesContacts',
        'app.Consequences',
        'app.Contracts',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ConsequencesContacts') ? [] : ['className' => ConsequencesContactsTable::class];
        $this->ConsequencesContacts = $this->getTableLocator()->get('ConsequencesContacts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ConsequencesContacts);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ConsequencesContactsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ConsequencesContactsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
