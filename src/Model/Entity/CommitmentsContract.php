<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CommitmentsContract Entity
 *
 * @property int $id
 * @property int $state_id
 * @property int $commitment_id
 * @property int $contract_id
 * @property string|null $packagename
 * @property string|null $starttime
 * @property string|null $endtime
 * @property int $allowedtime
 * @property int $allowedunlocks
 * @property int $exceedtime
 * @property int $eceedunlocks
 * @property int $totalbreaches
 *
 * @property \App\Model\Entity\State $state
 * @property \App\Model\Entity\Commitment $commitment
 * @property \App\Model\Entity\Contract $contract
 */
class CommitmentsContract extends Entity
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
        'state_id' => true,
        'commitment_id' => true,
        'contract_id' => true,
        'packagename' => true,
        'starttime' => true,
        'endtime' => true,
        'allowedtime' => true,
        'allowedunlocks' => true,
        'exceedtime' => true,
        'eceedunlocks' => true,
        'totalbreaches' => true,
        'state' => true,
        'commitment' => true,
        'contract' => true,
    ];
}
