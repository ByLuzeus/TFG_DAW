<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SectokensFixture
 */
class SectokensFixture extends TestFixture
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
                'date' => '2025-05-18 02:59:19',
                'valid' => 1,
                'user_username' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
