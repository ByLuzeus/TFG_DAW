<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Commitments Model
 *
 * @property \App\Model\Table\CommitmenttypesTable&\Cake\ORM\Association\BelongsTo $Commitmenttypes
 * @property \App\Model\Table\ContractsTable&\Cake\ORM\Association\BelongsToMany $Contracts
 * @property \App\Model\Table\ConsequencesTable&\Cake\ORM\Association\BelongsToMany $Consequences
 * @property \App\Model\Table\RewardsTable&\Cake\ORM\Association\BelongsToMany $Rewards
 *
 * @method \App\Model\Entity\Commitment newEmptyEntity()
 * @method \App\Model\Entity\Commitment newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Commitment[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Commitment get($primaryKey, $options = [])
 * @method \App\Model\Entity\Commitment findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Commitment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Commitment[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Commitment|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Commitment saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Commitment[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Commitment[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Commitment[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Commitment[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class CommitmentsTable extends Table
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

        $this->setTable('commitments');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Commitmenttypes', [
            'foreignKey' => 'type_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsToMany('Contracts', [
            'foreignKey' => 'commitment_id',
            'targetForeignKey' => 'contract_id',
            'joinTable' => 'commitments_contracts',
        ]);
        $this->belongsToMany('Consequences', [
            'foreignKey' => 'commitment_id',
            'targetForeignKey' => 'consequence_id',
            'joinTable' => 'consequences_commitments',
        ]);
        $this->belongsToMany('Rewards', [
            'foreignKey' => 'commitment_id',
            'targetForeignKey' => 'reward_id',
            'joinTable' => 'rewards_commitments',
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
            ->integer('type_id')
            ->notEmptyString('type_id');

        $validator
            ->scalar('description')
            ->maxLength('description', 100)
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

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
        $rules->add($rules->existsIn('type_id', 'Commitmenttypes'), ['errorField' => 'type_id']);

        return $rules;
    }
}
