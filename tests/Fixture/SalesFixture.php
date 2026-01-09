<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SalesFixture
 */
class SalesFixture extends TestFixture
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
                'salecode' => 'Lorem ipsum dolor sit amet',
                'saledate' => '2025-05-18',
                'username' => 'Lorem ipsum dolor sit amet',
                'paymentstatus' => 'Lorem ipsum dolor sit amet',
                'total' => 1.5,
                'paymentid' => 'Lorem ipsum dolor sit amet',
                'cofid' => 'Lorem ipsum dolor sit amet',
                'saletype' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
