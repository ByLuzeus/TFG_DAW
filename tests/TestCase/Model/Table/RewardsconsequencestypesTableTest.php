<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RewardsconsequencestypesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RewardsconsequencestypesTable Test Case
 */
class RewardsconsequencestypesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RewardsconsequencestypesTable
     */
    protected $Rewardsconsequencestypes;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
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
        $config = $this->getTableLocator()->exists('Rewardsconsequencestypes') ? [] : ['className' => RewardsconsequencestypesTable::class];
        $this->Rewardsconsequencestypes = $this->getTableLocator()->get('Rewardsconsequencestypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Rewardsconsequencestypes);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\RewardsconsequencestypesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
