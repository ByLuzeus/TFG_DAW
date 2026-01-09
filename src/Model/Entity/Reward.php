<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Reward Entity
 *
 * @property int $id
 * @property string $description
 * @property int $custompoints
 * @property int|null $userpoints
 * @property int $type_id
 *
 * @property \App\Model\Entity\Rewardsconsequencestype $rewardsconsequencestype
 * @property \App\Model\Entity\Commitment[] $commitments
 * @property \App\Model\Entity\Contract[] $contracts
 */
class Reward extends Entity
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
        'description' => true,
        'custompoints' => true,
        'userpoints' => true,
        'type_id' => true,
        'rewardsconsequencestype' => true,
        'commitments' => true,
        'contracts' => true,
        'user_id' => true,
        'user' => true,
        'username' => true,
    ];
}
