<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CommitmentsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CommitmentsTable Test Case
 */
class CommitmentsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CommitmentsTable
     */
    protected $Commitments;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Commitments',
        'app.Commitmenttypes',
        'app.Contracts',
        'app.Consequences',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Commitments') ? [] : ['className' => CommitmentsTable::class];
        $this->Commitments = $this->getTableLocator()->get('Commitments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Commitments);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CommitmentsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\CommitmentsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
