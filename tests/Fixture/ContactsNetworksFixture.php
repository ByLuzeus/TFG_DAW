<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ContactsNetworksFixture
 */
class ContactsNetworksFixture extends TestFixture
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
                'contact_id' => 1,
                'network_id' => 1,
                'url' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
