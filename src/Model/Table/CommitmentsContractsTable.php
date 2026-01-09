<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CommitmentsContracts Model
 *
 * @property \App\Model\Table\StatesTable&\Cake\ORM\Association\BelongsTo $States
 * @property \App\Model\Table\CommitmentsTable&\Cake\ORM\Association\BelongsTo $Commitments
 * @property \App\Model\Table\ContractsTable&\Cake\ORM\Association\BelongsTo $Contracts
 *
 * @method \App\Model\Entity\CommitmentsContract newEmptyEntity()
 * @method \App\Model\Entity\CommitmentsContract newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\CommitmentsContract[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CommitmentsContract get($primaryKey, $options = [])
 * @method \App\Model\Entity\CommitmentsContract findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\CommitmentsContract patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CommitmentsContract[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CommitmentsContract|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CommitmentsContract saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CommitmentsContract[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CommitmentsContract[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\CommitmentsContract[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CommitmentsContract[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class CommitmentsContractsTable extends Table
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

        $this->setTable('commitments_contracts');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('Details', [
            'className' => 'CommitmentcontractsDetails',
            'foreignKey' => 'commitmentcontract_id',
        ]);
        $this->belongsTo('States', [
            'foreignKey' => 'state_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Commitments', [
            'foreignKey' => 'commitment_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Contracts', [
            'foreignKey' => 'contract_id',
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
            ->integer('state_id')
            ->notEmptyString('state_id');

        $validator
            ->integer('commitment_id')
            ->notEmptyString('commitment_id');

        $validator
            ->integer('contract_id')
            ->notEmptyString('contract_id');

        $validator
            ->scalar('packagename')
            ->maxLength('packagename', 50)
            ->allowEmptyString('packagename');

        $validator
            ->scalar('starttime')
            ->maxLength('starttime', 10)
            ->allowEmptyString('starttime');

        $validator
            ->scalar('endtime')
            ->maxLength('endtime', 10)
            ->allowEmptyString('endtime');

        $validator
            ->integer('allowedtime')
            ->notEmptyString('allowedtime');

        $validator
            ->integer('allowedunlocks')
            ->notEmptyString('allowedunlocks');

        $validator
            ->integer('exceedtime')
            ->notEmptyString('exceedtime');

        $validator
            ->integer('eceedunlocks')
            ->notEmptyString('eceedunlocks');

        $validator
            ->integer('totalbreaches')
            ->notEmptyString('totalbreaches');

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
        $rules->add($rules->existsIn('state_id', 'States'), ['errorField' => 'state_id']);
        $rules->add($rules->existsIn('commitment_id', 'Commitments'), ['errorField' => 'commitment_id']);
        $rules->add($rules->existsIn('contract_id', 'Contracts'), ['errorField' => 'contract_id']);

        return $rules;
    }
}
