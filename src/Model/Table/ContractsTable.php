<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Contracts Model
 *
 * @property \App\Model\Table\StatesTable&\Cake\ORM\Association\BelongsTo $States
 * @property \App\Model\Table\ConsequencesContactsTable&\Cake\ORM\Association\HasMany $ConsequencesContacts
 * @property \App\Model\Table\RecordsTable&\Cake\ORM\Association\HasMany $Records
 * @property \App\Model\Table\SurveysTable&\Cake\ORM\Association\HasMany $Surveys
 * @property \App\Model\Table\CommitmentsTable&\Cake\ORM\Association\BelongsToMany $Commitments
 * @property \App\Model\Table\RewardsTable&\Cake\ORM\Association\BelongsToMany $Rewards
 *
 * @method \App\Model\Entity\Contract newEmptyEntity()
 * @method \App\Model\Entity\Contract newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Contract[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Contract get($primaryKey, $options = [])
 * @method \App\Model\Entity\Contract findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Contract patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Contract[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Contract|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Contract saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Contract[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Contract[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Contract[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Contract[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ContractsTable extends Table
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

        $this->setTable('contracts');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('States', [
            'foreignKey' => 'state_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'username',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('ConsequencesContacts', [
            'foreignKey' => 'contract_id',
        ]);
        $this->hasMany('Records', [
            'foreignKey' => 'contract_id',
        ]);
        $this->hasMany('Surveys', [
            'foreignKey' => 'contract_id',
        ]);
        $this->belongsToMany('Commitments', [
            'foreignKey' => 'contract_id',
            'targetForeignKey' => 'commitment_id',
            'joinTable' => 'commitments_contracts',
        ]);
        $this->belongsToMany('Rewards', [
            'foreignKey' => 'contract_id',
            'targetForeignKey' => 'reward_id',
            'joinTable' => 'rewards_contracts',
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
            ->scalar('username')
            ->maxLength('username', 50)
            ->requirePresence('username', 'create')
            ->notEmptyString('username');

        $validator
            ->integer('state_id')
            ->notEmptyString('state_id');

        $validator
            ->dateTime('startdate')
            ->notEmptyDateTime('startdate');

        $validator
            ->dateTime('enddate')
            ->requirePresence('enddate', 'create')
            ->notEmptyDateTime('enddate');

        $validator
            ->notEmptyString('parentagreement');

        $validator
            ->notEmptyString('childagreement');

        $validator
            ->notEmptyString('ended');

        $validator
            ->notEmptyString('active');

        $validator
            ->integer('breaches')
            ->notEmptyString('breaches');

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
        $rules->add($rules->isUnique(['username']), ['errorField' => 'username']);
        $rules->add($rules->existsIn('state_id', 'States'), ['errorField' => 'state_id']);

        return $rules;
    }
}
