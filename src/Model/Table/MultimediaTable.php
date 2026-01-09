<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Multimedia Model
 *
 * @property \App\Model\Table\ArticlesTable|\Cake\ORM\Association\HasMany $Articles
 * @property \App\Model\Table\WineriesTable|\Cake\ORM\Association\HasMany $Wineries
 * @property \App\Model\Table\WinesTable|\Cake\ORM\Association\HasMany $Wines
 * @property \App\Model\Table\AssetsTable|\Cake\ORM\Association\HasMany $Assets
 * @property \App\Model\Table\TimelinesTable|\Cake\ORM\Association\HasMany $Timelines
 * @property \App\Model\Table\NetworksTable|\Cake\ORM\Association\HasMany $Networks
 * @property \App\Model\Table\SlidersTable|\Cake\ORM\Association\HasMany $Sliders
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\HasMany $Users
 * * @property \App\Model\Table\TeamsTable|\Cake\ORM\Association\HasMany $Teams
 * @property \App\Model\Table\ArticlesTable|\Cake\ORM\Association\BelongsToMany $Articles
 *
 * @method \App\Model\Entity\Multimedia get($primaryKey, $options = [])
 * @method \App\Model\Entity\Multimedia newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Multimedia[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Multimedia|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Multimedia patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Multimedia[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Multimedia findOrCreate($search, callable $callback = null, $options = [])
 */
class MultimediaTable extends Table
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

        $this->setTable('multimedia');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

       
        $this->hasMany('Adminusers', [
            'foreignKey' => 'multimedia_id'
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
            ->scalar('url')
            ->maxLength('url', 255)
            ->requirePresence('url', 'create')
            ->notEmpty('url');

        $validator
            ->scalar('title')
            ->maxLength('title', 100)
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->scalar('alt')
            ->maxLength('alt', 150)
            ->allowEmpty('alt');

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
            ->allowEmpty('description');

        $validator
            ->scalar('mytype')
            ->maxLength('mytype', 20)
            ->allowEmpty('mytype');

        return $validator;
    }
}
