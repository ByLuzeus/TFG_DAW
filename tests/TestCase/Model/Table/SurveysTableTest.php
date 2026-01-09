<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SurveysTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SurveysTable Test Case
 */
class SurveysTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SurveysTable
     */
    protected $Surveys;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Surveys',
        'app.Contracts',
        'app.Questions',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Surveys') ? [] : ['className' => SurveysTable::class];
        $this->Surveys = $this->getTableLocator()->get('Surveys', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Surveys);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\SurveysTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\SurveysTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
