<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Contacts Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\TeamsTable|\Cake\ORM\Association\HasMany $Teams
 *
 * @method \App\Model\Entity\Contact get($primaryKey, $options = [])
 * @method \App\Model\Entity\Contact newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Contact[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Contact|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Contact patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Contact[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Contact findOrCreate($search, callable $callback = null, $options = [])
 */
class ContactsTable extends Table
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

        $this->setTable('contacts');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('Adminusers', [
            'foreignKey' => 'user_id'
        ]);

        $this->belongsToMany('Networks', [
            'foreignKey' => 'contact_id',
            'targetForeignKey' => 'network_id',
            'joinTable' => 'contacts_networks'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): \Cake\Validation\Validator
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('city')
            ->maxLength('city', 100)
            ->allowEmpty('city');

        $validator
            ->scalar('state')
            ->maxLength('state', 100)
            ->allowEmpty('state');

        $validator
            ->scalar('country')
            ->maxLength('country', 100)
            ->allowEmpty('country');

        $validator
            ->scalar('address')
            ->maxLength('address', 250)
            ->allowEmpty('address');

        $validator
            ->scalar('cp')
            ->maxLength('cp', 6)
            ->allowEmpty('cp');

        $validator
            ->email('email')
            ->allowEmpty('email');

        $validator
            ->scalar('tlfn')
            ->maxLength('tlfn', 15)
            ->allowEmpty('tlfn');

        $validator
            ->scalar('tlfn2')
            ->maxLength('tlfn2', 15)
            ->allowEmpty('tlfn2');

        $validator
            ->scalar('fax')
            ->maxLength('fax', 15)
            ->allowEmpty('fax');

        $validator
            ->numeric('latitude')
            ->allowEmpty('latitude');

        $validator
            ->numeric('longitude')
            ->allowEmpty('longitude');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): \Cake\ORM\RulesChecker
    {
      

        return $rules;
    }
}
