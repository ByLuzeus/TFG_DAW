<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CommitmentscontractsDetailsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CommitmentscontractsDetailsTable Test Case
 */
class CommitmentscontractsDetailsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CommitmentscontractsDetailsTable
     */
    protected $CommitmentscontractsDetails;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.CommitmentscontractsDetails',
        'app.CommitmentsContracts',
        'app.States',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('CommitmentscontractsDetails') ? [] : ['className' => CommitmentscontractsDetailsTable::class];
        $this->CommitmentscontractsDetails = $this->getTableLocator()->get('CommitmentscontractsDetails', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->CommitmentscontractsDetails);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CommitmentscontractsDetailsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\CommitmentscontractsDetailsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
