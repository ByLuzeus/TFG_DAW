<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\QuestionsSurveysTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\QuestionsSurveysTable Test Case
 */
class QuestionsSurveysTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\QuestionsSurveysTable
     */
    protected $QuestionsSurveys;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.QuestionsSurveys',
        'app.Surveys',
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
        $config = $this->getTableLocator()->exists('QuestionsSurveys') ? [] : ['className' => QuestionsSurveysTable::class];
        $this->QuestionsSurveys = $this->getTableLocator()->get('QuestionsSurveys', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->QuestionsSurveys);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\QuestionsSurveysTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\QuestionsSurveysTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
