<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * NotificationsUser Entity
 *
 * @property int $id
 * @property int $notification_id
 * @property string $username
 * @property \Cake\I18n\FrozenTime $notificationdate
 * @property bool $sended
 * @property string $response
 *
 * @property \App\Model\Entity\Notification $notification
 */
class NotificationsUser extends Entity
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
        'notification_id' => true,
        'username' => true,
        'notificationdate' => true,
        'sended' => true,
        'response' => true,
        'notification' => true,
    ];
}
