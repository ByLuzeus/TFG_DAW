<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * NotificationsUsersFixture
 */
class NotificationsUsersFixture extends TestFixture
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
                'notification_id' => 1,
                'username' => 'Lorem ipsum dolor sit amet',
                'notificationdate' => '2025-05-18 02:59:13',
                'sended' => 1,
                'response' => 'Lorem ipsum dolor sit amet',
                'extradata' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
