<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Survey Entity
 *
 * @property int $id
 * @property int $contract_id
 * @property \Cake\I18n\FrozenTime $surveydate
 * @property string $result
 *
 * @property \App\Model\Entity\Contract $contract
 * @property \App\Model\Entity\Question[] $questions
 */
class Survey extends Entity
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
        'contract_id' => true,
        'surveydate' => true,
        'result' => true,
        'contract' => true,
        'questions' => true,
    ];
}
