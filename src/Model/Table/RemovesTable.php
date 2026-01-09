<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RemovesTable
 */
class RemovesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);


        $this->setTable('removes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new'
                ]
            ]
        ]);


        $this->belongsTo('Users', [
            'foreignKey' => 'username', 
            'joinType' => 'INNER',
        ]);
    }


    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('username')
            ->maxLength('username', 50)
            ->requirePresence('username', 'create')
            ->notEmptyString('username', 'El campo username es obligatorio.');

        $validator
            ->scalar('observations')
            ->allowEmptyString('observations');

        return $validator;
    }
}