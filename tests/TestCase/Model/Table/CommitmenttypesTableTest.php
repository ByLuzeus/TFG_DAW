<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CommitmenttypesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CommitmenttypesTable Test Case
 */
class CommitmenttypesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CommitmenttypesTable
     */
    protected $Commitmenttypes;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Commitmenttypes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Commitmenttypes') ? [] : ['className' => CommitmenttypesTable::class];
        $this->Commitmenttypes = $this->getTableLocator()->get('Commitmenttypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Commitmenttypes);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CommitmenttypesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
