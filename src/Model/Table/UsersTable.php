<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \App\Model\Table\LevelsTable&\Cake\ORM\Association\BelongsTo $Levels
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\NotificationsTable&\Cake\ORM\Association\BelongsToMany $Notifications
 * @property \App\Model\Table\SectokensTable|\Cake\ORM\Association\HasMany $Sectokens
 * @property \App\Model\Table\ContractsTable|\Cake\ORM\Association\HasMany $Contracts
 *
 * @method \App\Model\Entity\User newEmptyEntity()
 * @method \App\Model\Entity\User newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('name');
        $this->setPrimaryKey('username');

        $this->belongsTo('Levels', [
            'foreignKey' => 'level_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsToMany('Notifications', [
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'notification_id',
            'joinTable' => 'notifications_users',
        ]);
        $this->hasMany('Sectokens', [
            'foreignKey' => 'user_username'
        ]);
        $this->hasMany('Contracts', [
            'foreignKey' => 'username'
        ]);
        $this->hasMany('Removes', [
            'foreignKey' => 'username',
        ]);
        $this->hasMany('AppdatasUsers', [
            'className' => 'Cake\ORM\Table',
            'table' => 'appdatas_users',
            'foreignKey' => 'users_username',
            'bindingKey' => 'username',
            'dependent' => false
        ]);

        $this->hasMany('Sectokens', [
            'className' => 'Cake\ORM\Table',
            'table' => 'sectokens',
            'foreignKey' => 'user_username',
            'bindingKey' => 'username',
            'dependent' => false
        ]);

        $this->hasMany('Children', [
            'className' => 'Users',
            'foreignKey' => 'father',
            'bindingKey' => 'username',
            'propertyName' => 'children',
        ]);

        $this->belongsTo('ParentUser', [
            'className' => 'Users',
            'foreignKey' => 'father',
            'bindingKey' => 'username',
            'propertyName' => 'parent_user',
            'joinType' => 'LEFT',
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
            ->allowEmptyString('father', null, function ($context) {
                return isset($context['data']['isfather']) && (int) $context['data']['isfather'] === 1;
            });
        $validator
            ->integer('level_id')
            ->notEmptyString('level_id');

        $validator
            ->scalar('name')
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('lastname')
            ->maxLength('lastname', 100)
            ->requirePresence('lastname', 'create')
            ->notEmptyString('lastname');

        $validator
            ->date('birthdate')
            ->requirePresence('birthdate', 'create')
            ->notEmptyDate('birthdate');

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')
            ->notEmptyString('password', null, 'create')
            ->allowEmptyString('password', null, 'update');

        $validator
            ->integer('rewardpoints')
            ->requirePresence('rewardpoints', 'create')
            ->notEmptyString('rewardpoints');

        $validator
            ->integer('consequencepoints')
            ->requirePresence('consequencepoints', 'create')
            ->notEmptyString('consequencepoints');

        $validator
            ->integer('totalpoints')
            ->requirePresence('totalpoints', 'create')
            ->notEmptyString('totalpoints');

        $validator->add('father', 'requiredForChild', [
            'rule' => function ($value, $context) {
                $isFatherFlag = isset($context['data']['isfather']) && (int) $context['data']['isfather'] === 1;
                return $isFatherFlag ? empty($context['data']['father'] ?? null)
                    : !empty($context['data']['father'] ?? null);
            },
            'message' => 'Un usuario hijo debe tener padre; un padre no puede tenerlo.',
        ]);
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
        $rules->add(function ($entity) {
            if (empty($entity->username)) {
                return true;
            }

            $u = mb_strtolower(trim((string) $entity->username));

            $query = $this->find()
                ->where(['LOWER(Users.username) =' => $u]);

            if (!$entity->isNew()) {
                $pk = $this->getPrimaryKey(); 
                $query->where([$pk . ' !=' => $entity->get($pk)]);
            }

            return $query->isEmpty();
        }, 'uniqueUsernameInsensitive', [
            'errorField' => 'username',
            'message' => 'Este nombre de usuario ya existe (no distingue mayúsculas/minúsculas).'
        ]);
        $rules->add(function ($entity) {
            if (empty($entity->username)) {
                return true;
            }

            $u = mb_strtolower(trim((string) $entity->username));

            $admins = \Cake\ORM\TableRegistry::getTableLocator()->get('Adminusers');
            $q = $admins->find()->where(['LOWER(Adminusers.username) =' => $u]);

            return $q->count() === 0;
        }, 'uniqueAcrossAdmins', [
            'errorField' => 'username',
            'message' => 'Ese nombre de usuario ya existe como administrador (Adminusers).'
        ]);

        $rules->add($rules->existsIn('level_id', 'Levels'), ['errorField' => 'level_id']);

        $rules->add(
            $rules->existsIn(
                ['father'],
                'ParentUser',
                ['allowNullableNulls' => true]
            ),
            [
                'errorField' => 'father',
                'message' => 'El padre seleccionado no existe.'
            ]
        );

        $rules->add(
            function ($entity) {
                if (!empty($entity->isfather) && (int) $entity->isfather === 1) {
                    return true;
                }
                if (empty($entity->father)) {
                    return false;
                }
                return $this->ParentUser->exists(['username' => $entity->father]);
            },
            'parentExists',
            [
                'errorField' => 'father',
                'message' => 'El padre seleccionado no existe.'
            ]
        );

        return $rules;
    }
}
