<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Sectokens Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\ProfilesGenre get($primaryKey, $options = [])
 * @method \App\Model\Entity\ProfilesGenre newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ProfilesGenre[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProfilesGenre|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProfilesGenre patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ProfilesGenre[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProfilesGenre findOrCreate($search, callable $callback = null, $options = [])
 */
class SectokensTable extends Table
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

        $this->setTable('sectokens');
        $this->setDisplayField('user_username');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_username',
            'joinType' => 'INNER'
        ]);
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
        $rules->add($rules->existsIn(['user_username'], 'Users'));

        return $rules;
    }
}
