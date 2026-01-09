<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ConsequencesFixture
 */
class ConsequencesFixture extends TestFixture
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
                'description' => 'Lorem ipsum dolor sit amet',
                'custompoints' => 1,
                'userpoints' => 1,
                'type_id' => 1,
            ],
        ];
        parent::init();
    }
}
