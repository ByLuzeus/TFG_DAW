<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CouponsFixture
 */
class CouponsFixture extends TestFixture
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
                'couponcode' => 'Lorem ipsum dolor sit a',
                'useslimit' => 1,
                'totaluses' => 1,
                'active' => 1,
                'percentage' => 1,
                'forever' => 1,
            ],
        ];
        parent::init();
    }
}
