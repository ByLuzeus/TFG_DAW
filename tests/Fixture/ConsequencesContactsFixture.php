<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ConsequencesContactsFixture
 */
class ConsequencesContactsFixture extends TestFixture
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
                'consequence_id' => 1,
                'contract_id' => 1,
                'state' => 1,
            ],
        ];
        parent::init();
    }
}
