<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RewardsCommitment Entity
 *
 * @property int $rewardscontract_id
 * @property int $commitmentscontract_id
 *
 * @property \App\Model\Entity\RewardsContract $rewards_contract
 * @property \App\Model\Entity\CommitmentsContract $commitmentscontract
 */
class RewardsCommitment extends Entity
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
        'rewards_contract' => true,
        'commitmentscontract' => true,
    ];
}
