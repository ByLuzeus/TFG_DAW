<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Contract Entity
 *
 * @property int $id
 * @property string $username
 * @property int $state_id
 * @property \Cake\I18n\FrozenTime $startdate
 * @property \Cake\I18n\FrozenTime $enddate
 * @property int $parentagreement
 * @property int $childagreement
 * @property int $ended
 * @property int $active
 * @property int $breaches
 *
 * @property \App\Model\Entity\State $state
 * @property \App\Model\Entity\ConsequencesContact[] $consequences_contacts
 * @property \App\Model\Entity\Record[] $records
 * @property \App\Model\Entity\Survey[] $surveys
 * @property \App\Model\Entity\Commitment[] $commitments
 * @property \App\Model\Entity\Reward[] $rewards
 */
class Contract extends Entity
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
        'state_id' => true,
        'startdate' => true,
        'enddate' => true,
        'parentagreement' => true,
        'childagreement' => true,
        'ended' => true,
        'active' => true,
        'breaches' => true,
        'state' => true,
        'consequences_contacts' => true,
        'records' => true,
        'surveys' => true,
        'commitments' => true,
        'rewards' => true,
    ];
}
