<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Surveys Model
 *
 * @property \App\Model\Table\ContractsTable&\Cake\ORM\Association\BelongsTo $Contracts
 * @property \App\Model\Table\QuestionsTable&\Cake\ORM\Association\BelongsToMany $Questions
 *
 * @method \App\Model\Entity\Survey newEmptyEntity()
 * @method \App\Model\Entity\Survey newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Survey[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Survey get($primaryKey, $options = [])
 * @method \App\Model\Entity\Survey findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Survey patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Survey[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Survey|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Survey saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Survey[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Survey[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Survey[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Survey[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class SurveysTable extends Table
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

        $this->setTable('surveys');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Contracts', [
            'foreignKey' => 'contract_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsToMany('Questions', [
            'foreignKey' => 'survey_id',
            'targetForeignKey' => 'question_id',
            'joinTable' => 'questions_surveys',
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
            ->integer('contract_id')
            ->notEmptyString('contract_id');

        $validator
            ->dateTime('surveydate')
            ->requirePresence('surveydate', 'create')
            ->notEmptyDateTime('surveydate');

        $validator
            ->scalar('result')
            ->maxLength('result', 20)
            ->requirePresence('result', 'create')
            ->notEmptyString('result');

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
        $rules->add($rules->existsIn('contract_id', 'Contracts'), ['errorField' => 'contract_id']);

        return $rules;
    }
}
