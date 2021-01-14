<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Fees Model
 *
 * @property \App\Model\Table\ReservationDetailsTable&\Cake\ORM\Association\HasMany $ReservationDetails
 *
 * @method \App\Model\Entity\Fee get($primaryKey, $options = [])
 * @method \App\Model\Entity\Fee newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Fee[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Fee|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Fee saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Fee patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Fee[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Fee findOrCreate($search, callable $callback = null, $options = [])
 */
class FeesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('fees');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('ReservationDetails', [
            'foreignKey' => 'fee_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->integer('fee')
            ->requirePresence('fee', 'create')
            ->notEmptyString('fee');

        $validator
            ->dateTime('started_at')
            ->requirePresence('started_at', 'create')
            ->notEmptyDateTime('started_at');

        $validator
            ->dateTime('finished_at')
            ->requirePresence('finished_at', 'create')
            ->notEmptyDateTime('finished_at');

        $validator
            ->boolean('is_deleted')
            ->notEmptyString('is_deleted');

        $validator
            ->dateTime('created_at')
            ->requirePresence('created_at', 'create')
            ->notEmptyDateTime('created_at');

        $validator
            ->dateTime('updated_at')
            ->requirePresence('updated_at', 'create')
            ->notEmptyDateTime('updated_at');

        return $validator;
    }
}
