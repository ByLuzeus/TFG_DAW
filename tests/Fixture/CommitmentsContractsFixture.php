<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CommitmentsContractsFixture
 */
class CommitmentsContractsFixture extends TestFixture
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
                'state_id' => 1,
                'commitment_id' => 1,
                'contract_id' => 1,
                'packagename' => 'Lorem ipsum dolor sit amet',
                'starttime' => 'Lorem ip',
                'endtime' => 'Lorem ip',
                'allowedtime' => 1,
                'allowedunlocks' => 1,
                'exceededtime' => 1,
                'exceededunlocks' => 1,
                'totalbreaches' => 1,
            ],
        ];
        parent::init();
    }
}
