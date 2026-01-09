<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ConsequencesCommitments Model
 *
 * @property \App\Model\Table\ConsequencesContactsTable&\Cake\ORM\Association\BelongsTo $ConsequencesContacts
 * @property \App\Model\Table\CommitmentsContractsTable&\Cake\ORM\Association\BelongsTo $Commitmentscontracts
 *
 * @method \App\Model\Entity\ConsequencesCommitment newEmptyEntity()
 * @method \App\Model\Entity\ConsequencesCommitment newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ConsequencesCommitment[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ConsequencesCommitment get($primaryKey, $options = [])
 * @method \App\Model\Entity\ConsequencesCommitment findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\ConsequencesCommitment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ConsequencesCommitment[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ConsequencesCommitment|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ConsequencesCommitment saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ConsequencesCommitment[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ConsequencesCommitment[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ConsequencesCommitment[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ConsequencesCommitment[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ConsequencesCommitmentsTable extends Table
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

        $this->setTable('consequences_commitments');
        $this->setDisplayField(['consequencescontract_id', 'commitmentscontract_id']);
        $this->setPrimaryKey(['consequencescontract_id', 'commitmentscontract_id']);

        $this->belongsTo('ConsequencesContacts', [
            'foreignKey' => 'consequencescontract_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Commitmentscontracts', [
            'foreignKey' => 'commitmentscontract_id',
            'joinType' => 'INNER',
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
        $rules->add($rules->existsIn('consequencescontract_id', 'ConsequencesContacts'), ['errorField' => 'consequencescontract_id']);
        $rules->add($rules->existsIn('commitmentscontract_id', 'Commitmentscontracts'), ['errorField' => 'commitmentscontract_id']);

        return $rules;
    }
}
