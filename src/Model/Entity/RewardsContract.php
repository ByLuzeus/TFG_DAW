<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RewardsContract Entity
 *
 * @property int $id
 * @property int $reward_id
 * @property int $contract_id
 * @property bool $state
 *
 * @property \App\Model\Entity\Reward $reward
 * @property \App\Model\Entity\Contract $contract
 */
class RewardsContract extends Entity
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
        'reward_id' => true,
        'contract_id' => true,
        'state' => true,
        'reward' => true,
        'contract' => true,
    ];
}
