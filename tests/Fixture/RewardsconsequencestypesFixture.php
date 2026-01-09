<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RewardsconsequencestypesFixture
 */
class RewardsconsequencestypesFixture extends TestFixture
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
                'points' => 1,
            ],
        ];
        parent::init();
    }
}
