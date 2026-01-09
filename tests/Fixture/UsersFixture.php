<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
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
                'username' => 'e2e979f0-580b-45a3-a48b-f95199684362',
                'level_id' => 1,
                'email' => 'Lorem ipsum dolor sit amet',
                'name' => 'Lorem ipsum dolor sit amet',
                'lastname' => 'Lorem ipsum dolor sit amet',
                'birthdate' => '2025-05-18',
                'genre' => 'Lorem ipsum dolor ',
                'phone' => 'Lorem ipsum dolor ',
                'password' => 'Lorem ipsum dolor sit amet',
                'rewardpoints' => 1.5,
                'consequencepoints' => 1,
                'totalpoints' => 1.5,
                'city' => 'Lorem ipsum dolor sit amet',
                'isfather' => 1,
                'father' => 'Lorem ipsum dolor sit amet',
                'avatar' => 1,
                'policyagreement' => 1,
                'allowed' => 1,
                'fbtoken' => 'Lorem ipsum dolor sit amet',
                'devicetype' => 'L',
                'lastlanguage' => 'Lo',
                'pointstosubstract' => 1,
            ],
        ];
        parent::init();
    }
}
