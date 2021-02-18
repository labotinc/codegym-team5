<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Points Model
 *
 * @property \App\Model\Table\MembersTable&\Cake\ORM\Association\BelongsTo $Members
 * @property \App\Model\Table\SchedulesTable&\Cake\ORM\Association\BelongsTo $Schedules
 *
 * @method \App\Model\Entity\Point get($primaryKey, $options = [])
 * @method \App\Model\Entity\Point newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Point[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Point|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Point saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Point patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Point[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Point findOrCreate($search, callable $callback = null, $options = [])
 */
class PointsTable extends Table
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

        $this->setTable('points');
        $this->setDisplayField('member_id');
        $this->setPrimaryKey(['member_id', 'schedule_id', 'column_number', 'record_number', 'is_minus']);

        $this->belongsTo('Payments', [
            'foreignKey' => ['member_id', 'schedule_id', 'column_number', 'record_number'],
            'joinType' => 'INNER',
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
            ->scalar('column_number')
            ->maxLength('column_number', 2)
            ->allowEmptyString('column_number', null, 'create');

        $validator
            ->scalar('record_number')
            ->maxLength('record_number', 2)
            ->allowEmptyString('record_number', null, 'create');

        $validator
            ->integer('point')
            ->requirePresence('point', 'create')
            ->notEmptyString('point');

        $validator
            ->boolean('is_minus')
            ->notEmptyString('is_minus');

        $validator
            ->boolean('is_cancelled')
            ->notEmptyString('is_cancelled');

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
        // $rules->add($rules->existsIn(['member_id'], 'Members'));
        // $rules->add($rules->existsIn(['schedule_id'], 'Schedules'));

        return $rules;
    }

    public function findApplyPointEntity(Query $query, array $options)
    {
        $mainKey = $options['mainKey'];
        $isMinus = $options['is_minus'];

        return $query
            ->where($mainKey)
            ->andwhere(['is_minus' => $isMinus])
            ->select([
                'member_id',
                'schedule_id',
                'column_number',
                'record_number',
                'point',
                'is_minus',
                'is_cancelled',
            ])
            ->toArray();
    }
}
