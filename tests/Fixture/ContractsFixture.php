<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ContractsFixture
 */
class ContractsFixture extends TestFixture
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
                'username' => 'Lorem ipsum dolor sit amet',
                'state_id' => 1,
                'startdate' => '2025-05-18 02:59:08',
                'enddate' => '2025-05-18 02:59:08',
                'parentagreement' => 1,
                'childagreement' => 1,
                'ended' => 1,
                'active' => 1,
                'breaches' => 1,
                'contractdate' => '2025-05-18',
                'exclusions' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'festivities' => 'Lorem ipsum dolor sit amet',
                'lastupdate' => '2025-05-18 02:59:08',
            ],
        ];
        parent::init();
    }
}
