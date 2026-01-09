<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * QuestionsSurveysFixture
 */
class QuestionsSurveysFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'survey_id' => 1,
                'question_id' => 1,
                'response' => 'Lorem ipsum dolor ',
            ],
        ];
        parent::init();
    }
}
