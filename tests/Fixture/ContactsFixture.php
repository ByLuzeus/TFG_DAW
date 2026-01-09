<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ContactsFixture
 */
class ContactsFixture extends TestFixture
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
                'city' => 'Lorem ipsum dolor sit amet',
                'state' => 'Lorem ipsum dolor sit amet',
                'country' => 'Lorem ipsum dolor sit amet',
                'address' => 'Lorem ipsum dolor sit amet',
                'cp' => 'Lore',
                'email' => 'Lorem ipsum dolor sit amet',
                'tlfn' => 'Lorem ipsum d',
                'tlfn2' => 'Lorem ipsum d',
                'fax' => 'Lorem ipsum d',
                'latitude' => 1,
                'longitude' => 1,
            ],
        ];
        parent::init();
    }
}
