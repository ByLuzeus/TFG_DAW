<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AppdatasUsersFixture
 */
class AppdatasUsersFixture extends TestFixture
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
                'appdatas_id' => 1,
                'users_username' => 'c78f36c6-a563-4a7d-bc33-410220754920',
            ],
        ];
        parent::init();
    }
}
