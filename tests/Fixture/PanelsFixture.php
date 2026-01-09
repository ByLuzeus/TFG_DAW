<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PanelsFixture
 */
class PanelsFixture extends TestFixture
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
                'id' => '1afcff45-58f2-4206-bca2-f1f450ea8503',
                'request_id' => '7a985f48-78cb-4438-b2d9-ef4bd6e6f486',
                'panel' => 'Lorem ipsum dolor sit amet',
                'title' => 'Lorem ipsum dolor sit amet',
                'element' => 'Lorem ipsum dolor sit amet',
                'summary' => 'Lorem ipsum dolor sit amet',
                'content' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
