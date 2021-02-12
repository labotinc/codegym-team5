<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Creditcards Model
 *
 * @property \App\Model\Table\MembersTable&\Cake\ORM\Association\BelongsTo $Members
 * @property \App\Model\Table\PaymentsTable&\Cake\ORM\Association\HasMany $Payments
 *
 * @method \App\Model\Entity\Creditcard get($primaryKey, $options = [])
 * @method \App\Model\Entity\Creditcard newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Creditcard[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Creditcard|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Creditcard saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Creditcard patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Creditcard[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Creditcard findOrCreate($search, callable $callback = null, $options = [])
 */
class CreditcardsTable extends Table
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

        $this->setTable('creditcards');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Members', [
            'foreignKey' => 'member_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Payments', [
            'foreignKey' => 'creditcard_id',
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
            ->scalar('card_number')
            ->maxLength('card_number', 100)
            ->requirePresence('card_number', 'create')
            ->notEmptyString('card_number');

        $validator
            ->scalar('name')
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('deadline')
            ->maxLength('deadline', 5)
            ->requirePresence('deadline', 'create')
            ->notEmptyString('deadline');

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

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['member_id'], 'Members'));

        return $rules;
    }
}
