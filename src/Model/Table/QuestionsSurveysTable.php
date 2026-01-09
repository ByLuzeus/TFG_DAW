<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * QuestionsSurveys Model
 *
 * @property \App\Model\Table\SurveysTable&\Cake\ORM\Association\BelongsTo $Surveys
 * @property \App\Model\Table\QuestionsTable&\Cake\ORM\Association\BelongsTo $Questions
 *
 * @method \App\Model\Entity\QuestionsSurvey newEmptyEntity()
 * @method \App\Model\Entity\QuestionsSurvey newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\QuestionsSurvey[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\QuestionsSurvey get($primaryKey, $options = [])
 * @method \App\Model\Entity\QuestionsSurvey findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\QuestionsSurvey patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\QuestionsSurvey[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\QuestionsSurvey|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\QuestionsSurvey saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\QuestionsSurvey[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\QuestionsSurvey[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\QuestionsSurvey[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\QuestionsSurvey[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class QuestionsSurveysTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('questions_surveys');
        $this->setDisplayField(['survey_id', 'question_id']);
        $this->setPrimaryKey(['survey_id', 'question_id']);

        $this->belongsTo('Surveys', [
            'foreignKey' => 'survey_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Questions', [
            'foreignKey' => 'question_id',
            'joinType' => 'INNER',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('response')
            ->maxLength('response', 20)
            ->requirePresence('response', 'create')
            ->notEmptyString('response');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn('survey_id', 'Surveys'), ['errorField' => 'survey_id']);
        $rules->add($rules->existsIn('question_id', 'Questions'), ['errorField' => 'question_id']);

        return $rules;
    }
}
