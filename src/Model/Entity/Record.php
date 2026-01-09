<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Record Entity
 *
 * @property int $id
 * @property int $contract_id
 * @property string $packagename
 * @property int $startdate
 * @property int|null $enddate
 *
 * @property \App\Model\Entity\Contract $contract
 */
class Record extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'packagename' => true,
        'startdate' => true,
        'enddate' => true,
        'contract' => true,
    ];
}
