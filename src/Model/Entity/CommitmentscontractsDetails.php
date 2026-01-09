<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CommitmentsContract Entity
 *
 * @property int $status_id
 * @property int $commitmentcontact_id
 * @property \Cake\I18n\FrozenTime $mydate
 * @property int $exceededtime
 * @property int $totalbreaches
 */
class CommitmentscontractsDetails extends Entity
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
        'status_id' => true,
        'commitmentcontact_id' => true,
        'mydate' => true,
        'exceededtime' => true,
        'totalbreaches' => true,
    ];
}
