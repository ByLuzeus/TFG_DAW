<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Welcomemessages Model
 *
 * @method \App\Model\Entity\Welcomemessage newEmptyEntity()
 * @method \App\Model\Entity\Welcomemessage newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Welcomemessage[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Welcomemessage get($primaryKey, $options = [])
 * @method \App\Model\Entity\Welcomemessage findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Welcomemessage patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Welcomemessage[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Welcomemessage|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Welcomemessage saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Welcomemessage[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Welcomemessage[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Welcomemessage[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Welcomemessage[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class WelcomemessagesTable extends Table
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

        $this->setTable('welcomemessages');
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
            ->scalar('text')
            ->maxLength('text', 50)
            ->requirePresence('text', 'create')
            ->notEmptyString('text');

        return $validator;
    }
}
