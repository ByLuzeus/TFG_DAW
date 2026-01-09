<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Remove Entity
 *
 * @property int $id
 * @property string $user_username
 * @property \Cake\I18n\FrozenTime $created
 * @property string|null $observations
 * @property \App\Model\Entity\User $user
 */
class Remove extends Entity
{
    protected $_accessible = [
        'username' => true,
        'created' => true,
        'observations' => true,
        'user' => true, // Relación a Users
        'keepanonymous' => true,
    ];
}