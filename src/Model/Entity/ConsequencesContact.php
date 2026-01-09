<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ConsequencesContact Entity
 *
 * @property int $id
 * @property int $consequence_id
 * @property int $contract_id
 * @property bool $state
 *
 * @property \App\Model\Entity\Consequence $consequence
 * @property \App\Model\Entity\Contract $contract
 */
class ConsequencesContact extends Entity
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
        'consequence_id' => true,
        'contract_id' => true,
        'state' => true,
        'consequence' => true,
        'contract' => true,
    ];
}
