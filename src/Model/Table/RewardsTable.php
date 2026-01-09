<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Rewards Model
 *
 * @property \App\Model\Table\RewardsconsequencestypesTable&\Cake\ORM\Association\BelongsTo $Rewardsconsequencestypes
 * @property \App\Model\Table\CommitmentsTable&\Cake\ORM\Association\BelongsToMany $Commitments
 * @property \App\Model\Table\ContractsTable&\Cake\ORM\Association\BelongsToMany $Contracts
 *
 * @method \App\Model\Entity\Reward newEmptyEntity()
 * @method \App\Model\Entity\Reward newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Reward[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Reward get($primaryKey, $options = [])
 * @method \App\Model\Entity\Reward findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Reward patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Reward[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Reward|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Reward saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Reward[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Reward[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Reward[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Reward[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class RewardsTable extends Table
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

        $this->setTable('rewards');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Rewardsconsequencestypes', [
            'foreignKey' => 'type_id',
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
            ->scalar('description')
            ->maxLength('description', 200)
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        $validator
            ->notEmptyString('custompoints');

        $validator
            ->integer('userpoints')
            ->allowEmptyString('userpoints');

        $validator
            ->integer('type_id')
            ->notEmptyString('type_id');

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
        $rules->add($rules->existsIn('type_id', 'Rewardsconsequencestypes'), ['errorField' => 'type_id']);

        return $rules;
    }
}
