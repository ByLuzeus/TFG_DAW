<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RecordsFixture
 */
class RecordsFixture extends TestFixture
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
                'contract_id' => 1,
                'packagename' => 'Lorem ipsum dolor sit amet',
                'startdatesystem' => 1,
                'enddatesystem' => 1,
                'startdateuser' => 1,
                'enddateuser' => 1,
                'open' => 1,
                'usedtime' => 1,
                'eventtype' => 1,
                'sent' => 1,
            ],
        ];
        parent::init();
    }
}
