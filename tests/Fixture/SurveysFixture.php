<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SurveysFixture
 */
class SurveysFixture extends TestFixture
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
                'id' => 1,
                'contract_id' => 1,
                'surveydate' => '2025-05-18 02:59:20',
                'result' => 'Lorem ipsum dolor ',
            ],
        ];
        parent::init();
    }
}
