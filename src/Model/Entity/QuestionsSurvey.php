<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * QuestionsSurvey Entity
 *
 * @property int $survey_id
 * @property int $question_id
 * @property string $response
 *
 * @property \App\Model\Entity\Survey $survey
 * @property \App\Model\Entity\Question $question
 */
class QuestionsSurvey extends Entity
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
        'response' => true,
        'survey' => true,
        'question' => true,
    ];
}
