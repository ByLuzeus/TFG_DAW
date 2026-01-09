<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RewardsCommitments Model
 *
 * @property \App\Model\Table\RewardsContractsTable&\Cake\ORM\Association\BelongsTo $RewardsContracts
 * @property \App\Model\Table\CommitmentsContractsTable&\Cake\ORM\Association\BelongsTo $Commitmentscontracts
 *
 * @method \App\Model\Entity\RewardsCommitment newEmptyEntity()
 * @method \App\Model\Entity\RewardsCommitment newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\RewardsCommitment[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RewardsCommitment get($primaryKey, $options = [])
 * @method \App\Model\Entity\RewardsCommitment findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\RewardsCommitment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RewardsCommitment[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\RewardsCommitment|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RewardsCommitment saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RewardsCommitment[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\RewardsCommitment[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\RewardsCommitment[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\RewardsCommitment[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class RewardsCommitmentsTable extends Table
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

        $this->setTable('rewards_commitments');
        $this->setDisplayField(['rewardscontract_id', 'commitmentscontract_id']);
        $this->setPrimaryKey(['rewardscontract_id', 'commitmentscontract_id']);

        $this->belongsTo('RewardsContracts', [
            'foreignKey' => 'rewardscontract_id',
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
        $rules->add($rules->existsIn('rewardscontract_id', 'RewardsContracts'), ['errorField' => 'rewardscontract_id']);
        $rules->add($rules->existsIn('commitmentscontract_id', 'Commitmentscontracts'), ['errorField' => 'commitmentscontract_id']);

        return $rules;
    }
}
