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
class AppdatasTable extends Table
{
    public function initialize(array $config): void
    {
        $this->setTable('appdatas');
        $this->setPrimaryKey('id');
        $this->setDisplayField('appname');
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('appname')
            ->maxLength('appname', 255)
            ->requirePresence('appname', 'create')
            ->notEmptyString('appname');

        $validator
            ->scalar('packagename')
            ->maxLength('packagename', 255)
            ->requirePresence('packagename', 'create')
            ->notEmptyString('packagename');

        $validator
            ->integer('devicetype')
            ->requirePresence('devicetype', 'create')
            ->range('devicetype', [0, 1], 'Debe ser 0 (Android) o 1 (iOS)');

        $validator
            ->scalar('appcategory')
            ->maxLength('appcategory', 255)
            ->requirePresence('appcategory', 'create')
            ->notEmptyString('appcategory');

        $validator
            ->scalar('appcategory_en')
            ->maxLength('appcategory_en', 255)
            ->requirePresence('appcategory_en', 'create')
            ->notEmptyString('appcategory_en');

        $validator
            ->integer('appicon')
            ->allowEmptyString('appicon');

        $validator
            ->date('timestamp')
            ->allowEmptyDate('timestamp');

        return $validator;
    }
}
