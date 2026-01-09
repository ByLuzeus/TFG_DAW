<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Rewardsconsequencestypes Model
 *
 * @method \App\Model\Entity\Rewardsconsequencestype newEmptyEntity()
 * @method \App\Model\Entity\Rewardsconsequencestype newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Rewardsconsequencestype[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Rewardsconsequencestype get($primaryKey, $options = [])
 * @method \App\Model\Entity\Rewardsconsequencestype findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Rewardsconsequencestype patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Rewardsconsequencestype[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Rewardsconsequencestype|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Rewardsconsequencestype saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Rewardsconsequencestype[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Rewardsconsequencestype[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Rewardsconsequencestype[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Rewardsconsequencestype[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class RewardsconsequencestypesTable extends Table
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

        $this->setTable('rewardsconsequencestypes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
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
            ->maxLength('description', 20)
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        $validator
            ->integer('points')
            ->notEmptyString('points');

        return $validator;
    }
}
