<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LevelsFixture
 */
class LevelsFixture extends TestFixture
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
                'description' => 'Lorem ipsum dolor ',
                'pointsprice' => 1,
            ],
        ];
        parent::init();
    }
}
