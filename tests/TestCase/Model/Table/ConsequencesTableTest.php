<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ConsequencesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ConsequencesTable Test Case
 */
class ConsequencesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ConsequencesTable
     */
    protected $Consequences;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Consequences',
        'app.Rewardsconsequencestypes',
        'app.Commitments',
        'app.Contacts',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Consequences') ? [] : ['className' => ConsequencesTable::class];
        $this->Consequences = $this->getTableLocator()->get('Consequences', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Consequences);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ConsequencesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ConsequencesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
