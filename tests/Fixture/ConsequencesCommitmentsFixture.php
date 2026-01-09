<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ConsequencesCommitmentsFixture
 */
class ConsequencesCommitmentsFixture extends TestFixture
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
                'consequencescontract_id' => 1,
                'commitmentscontract_id' => 1,
            ],
        ];
        parent::init();
    }
}
