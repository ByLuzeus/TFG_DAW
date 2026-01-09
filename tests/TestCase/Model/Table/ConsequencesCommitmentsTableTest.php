<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ConsequencesCommitmentsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ConsequencesCommitmentsTable Test Case
 */
class ConsequencesCommitmentsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ConsequencesCommitmentsTable
     */
    protected $ConsequencesCommitments;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.ConsequencesCommitments',
        'app.ConsequencesContacts',
        'app.Commitmentscontracts',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ConsequencesCommitments') ? [] : ['className' => ConsequencesCommitmentsTable::class];
        $this->ConsequencesCommitments = $this->getTableLocator()->get('ConsequencesCommitments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ConsequencesCommitments);

        parent::tearDown();
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ConsequencesCommitmentsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
