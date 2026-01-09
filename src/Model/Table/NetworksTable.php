<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Networks Model
 *
 * @property \App\Model\Table\MultimediaTable|\Cake\ORM\Association\BelongsTo $Multimedia
 * @property \App\Model\Table\TeamsTable|\Cake\ORM\Association\BelongsToMany $Teams
 *
 * @method \App\Model\Entity\Network get($primaryKey, $options = [])
 * @method \App\Model\Entity\Network newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Network[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Network|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Network patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Network[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Network findOrCreate($search, callable $callback = null, $options = [])
 */
class NetworksTable extends Table
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

        $this->setTable('networks');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Multimedia', [
            'foreignKey' => 'multimedia_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsToMany('Contacts', [
            'foreignKey' => 'network_id',
            'targetForeignKey' => 'contact_id',
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
            ->scalar('name')
            ->maxLength('name', 50)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

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
        $rules->add($rules->existsIn(['multimedia_id'], 'Multimedia'));

        return $rules;
    }
}
