<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Commitment Entity
 *
 * @property int $id
 *
 */
class Appdata extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
