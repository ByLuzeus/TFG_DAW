<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CommitmentsContractsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CommitmentsContractsTable Test Case
 */
class CommitmentsContractsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CommitmentsContractsTable
     */
    protected $CommitmentsContracts;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.CommitmentsContracts',
        'app.States',
        'app.Commitments',
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
        $config = $this->getTableLocator()->exists('CommitmentsContracts') ? [] : ['className' => CommitmentsContractsTable::class];
        $this->CommitmentsContracts = $this->getTableLocator()->get('CommitmentsContracts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->CommitmentsContracts);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CommitmentsContractsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\CommitmentsContractsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
