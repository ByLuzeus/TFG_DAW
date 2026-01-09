<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RewardsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RewardsTable Test Case
 */
class RewardsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RewardsTable
     */
    protected $Rewards;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Rewards',
        'app.Rewardsconsequencestypes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Rewards') ? [] : ['className' => RewardsTable::class];
        $this->Rewards = $this->getTableLocator()->get('Rewards', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Rewards);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\RewardsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\RewardsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
