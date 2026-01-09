<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ConsequencesContacts Model
 *
 * @property \App\Model\Table\ConsequencesTable&\Cake\ORM\Association\BelongsTo $Consequences
 * @property \App\Model\Table\ContractsTable&\Cake\ORM\Association\BelongsTo $Contracts
 *
 * @method \App\Model\Entity\ConsequencesContact newEmptyEntity()
 * @method \App\Model\Entity\ConsequencesContact newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ConsequencesContact[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ConsequencesContact get($primaryKey, $options = [])
 * @method \App\Model\Entity\ConsequencesContact findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\ConsequencesContact patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ConsequencesContact[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ConsequencesContact|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ConsequencesContact saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ConsequencesContact[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ConsequencesContact[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ConsequencesContact[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ConsequencesContact[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ConsequencesContactsTable extends Table
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

        $this->setTable('consequences_contacts');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Consequences', [
            'foreignKey' => 'consequence_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Contracts', [
            'foreignKey' => 'contract_id',
            'joinType' => 'INNER',
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
            ->integer('consequence_id')
            ->notEmptyString('consequence_id');

        $validator
            ->integer('contract_id')
            ->notEmptyString('contract_id');

        $validator
            ->boolean('state')
            ->notEmptyString('state');

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
        $rules->add($rules->existsIn('consequence_id', 'Consequences'), ['errorField' => 'consequence_id']);
        $rules->add($rules->existsIn('contract_id', 'Contracts'), ['errorField' => 'contract_id']);

        return $rules;
    }
}
