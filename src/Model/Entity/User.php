<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;


/**
 * User Entity
 *
 * @property string $username
 * @property int $level_id
 * @property string $email
 * @property string $name
 * @property string $lastname
 * @property \Cake\I18n\FrozenDate $birthdate
 * @property string $genre
 * @property string $phone
 * @property string $city
 * @property string $password
 * @property int $rewardpoints
 * @property int $consequencepoints
 * @property int $totalpoints
 * @property int $isfather
 * @property string fatherusername
 *
 * @property \App\Model\Entity\Level $level
 * @property \App\Model\Entity\Notification[] $notifications
 * @property \App\Model\Entity\Sectoken $sectoken
 * @property \App\Model\Entity\Contract[] $contracts
 * @property \App\Model\Entity\User $father
 */
class User extends Entity
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
        'username' => true,
        'level_id' => true,
        'email' => true,
        'name' => true,
        'lastname' => true,
        'city' => true,
        'birthdate' => true,
        'genre' => true,
        'phone' => true,
        'password' => true,
        'rewardpoints' => true,
        'consequencepoints' => true,
        'totalpoints' => true,
        'level' => true,
        'notifications' => true,
        'sectoken' => true,
        'contracts' => true,
        'isfather' => true,
        'fatherusername' => true,
        'father' => true,
        'avatar' => true,
        'policyagreement' => true,
        'fbtoken' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array<string>
     */
    protected $_hidden = [
        'password',
    ];

    protected function _setPassword($password)
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher)->hash($password);
        }
    }
}
