<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Commitment Entity
 *
 * @property int $id
 * @property int $type_id
 * @property string $description
 *
 * @property \App\Model\Entity\Commitmenttype $commitmenttype
 * @property \App\Model\Entity\Contract[] $contracts
 * @property \App\Model\Entity\Consequence[] $consequences
 * @property \App\Model\Entity\Reward[] $rewards
 */
class Commitment extends Entity
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
        'type_id' => true,
        'description' => true,
        'commitmenttype' => true,
        'contracts' => true,
        'consequences' => true,
        'rewards' => true,
    ];
}
