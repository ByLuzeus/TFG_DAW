<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AppdatasTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AppdatasTable Test Case
 */
class AppdatasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AppdatasTable
     */
    protected $Appdatas;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Appdatas',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Appdatas') ? [] : ['className' => AppdatasTable::class];
        $this->Appdatas = $this->getTableLocator()->get('Appdatas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Appdatas);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\AppdatasTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
