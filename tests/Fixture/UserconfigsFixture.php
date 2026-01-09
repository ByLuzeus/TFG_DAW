<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UserconfigsFixture
 */
class UserconfigsFixture extends TestFixture
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
                'user_username' => 'bb9acb8b-2235-4ae6-aed2-623079751ed1',
                'parentality' => 1,
                'notificationprefs' => 'Lorem ipsum dolor sit amet',
                'extratimeprefs' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
