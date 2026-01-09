<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Coupon Entity
 *
 * @property int $id
 * @property string $couponcode
 * @property int $useslimit
 * @property int $totaluses
 * @property int $active
 * @property int $percentage
 * @property int $forever
 *
 * @property \App\Model\Entity\User[] $users
 */
class Coupon extends Entity
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
        'couponcode' => true,
        'useslimit' => true,
        'totaluses' => true,
        'active' => true,
        'percentage' => true,
        'forever' => true,
    ];
}
