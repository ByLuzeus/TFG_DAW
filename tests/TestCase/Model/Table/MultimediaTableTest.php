<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MultimediaTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MultimediaTable Test Case
 */
class MultimediaTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MultimediaTable
     */
    protected $Multimedia;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Multimedia',
        'app.Adminusers',
        'app.Networks',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Multimedia') ? [] : ['className' => MultimediaTable::class];
        $this->Multimedia = $this->getTableLocator()->get('Multimedia', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Multimedia);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\MultimediaTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
