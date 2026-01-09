<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RewardsContracts Model
 *
 * @property \App\Model\Table\RewardsTable&\Cake\ORM\Association\BelongsTo $Rewards
 * @property \App\Model\Table\ContractsTable&\Cake\ORM\Association\BelongsTo $Contracts
 *
 * @method \App\Model\Entity\RewardsContract newEmptyEntity()
 * @method \App\Model\Entity\RewardsContract newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\RewardsContract[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RewardsContract get($primaryKey, $options = [])
 * @method \App\Model\Entity\RewardsContract findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\RewardsContract patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RewardsContract[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\RewardsContract|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RewardsContract saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RewardsContract[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\RewardsContract[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\RewardsContract[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\RewardsContract[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class RewardsContractsTable extends Table
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

        $this->setTable('rewards_contracts');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Rewards', [
            'foreignKey' => 'reward_id',
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
            ->integer('reward_id')
            ->notEmptyString('reward_id');

        $validator
            ->integer('contract_id')
            ->notEmptyString('contract_id');

        $validator
            ->boolean('state')
            ->notEmptyString('state');

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
        $rules->add($rules->existsIn('reward_id', 'Rewards'), ['errorField' => 'reward_id']);
        $rules->add($rules->existsIn('contract_id', 'Contracts'), ['errorField' => 'contract_id']);

        return $rules;
    }
}
