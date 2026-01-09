<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WelcomemessagesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WelcomemessagesTable Test Case
 */
class WelcomemessagesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\WelcomemessagesTable
     */
    protected $Welcomemessages;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Welcomemessages',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Welcomemessages') ? [] : ['className' => WelcomemessagesTable::class];
        $this->Welcomemessages = $this->getTableLocator()->get('Welcomemessages', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Welcomemessages);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\WelcomemessagesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
