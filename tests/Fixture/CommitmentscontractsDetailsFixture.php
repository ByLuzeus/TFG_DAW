<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CommitmentscontractsDetailsFixture
 */
class CommitmentscontractsDetailsFixture extends TestFixture
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
                'commitmentcontract_id' => 1,
                'exceededtime' => 1,
                'exceededunlocks' => 1,
                'mydate' => '2025-05-18',
                'status_id' => 1,
            ],
        ];
        parent::init();
    }
}
