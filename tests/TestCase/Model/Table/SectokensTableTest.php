<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SectokensTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SectokensTable Test Case
 */
class SectokensTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SectokensTable
     */
    protected $Sectokens;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Sectokens',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Sectokens') ? [] : ['className' => SectokensTable::class];
        $this->Sectokens = $this->getTableLocator()->get('Sectokens', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Sectokens);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\SectokensTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
