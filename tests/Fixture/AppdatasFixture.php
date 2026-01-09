<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AppdatasFixture
 */
class AppdatasFixture extends TestFixture
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
                'packagename' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'appname' => 'Lorem ipsum dolor sit amet',
                'devicetype' => 1,
                'appicon' => 'Lorem ipsum dolor sit amet',
                'timestamp' => '2025-05-18',
                'appcategory' => 'Lorem ipsum dolor sit amet',
                'appcategory_en' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
