<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LegalsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LegalsTable Test Case
 */
class LegalsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LegalsTable
     */
    protected $Legals;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Legals',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Legals') ? [] : ['className' => LegalsTable::class];
        $this->Legals = $this->getTableLocator()->get('Legals', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Legals);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\LegalsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
