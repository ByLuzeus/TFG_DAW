<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LicensesFixture
 */
class LicensesFixture extends TestFixture
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
                'licensekey' => 'Lorem ipsum dolor sit amet',
                'used' => 1,
                'email' => 'Lorem ipsum dolor sit amet',
                'active' => 1,
                'username' => 'Lorem ipsum dolor sit amet',
                'lastpayment' => '2025-05-18',
                'firstpayment' => '2025-05-18',
                'free' => 1,
                'sale_id' => 1,
                'discount' => 1,
            ],
        ];
        parent::init();
    }
}
