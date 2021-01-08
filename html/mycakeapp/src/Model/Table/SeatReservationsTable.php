<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SeatReservations Model
 *
 * @property \App\Model\Table\MembersTable&\Cake\ORM\Association\BelongsTo $Members
 * @property \App\Model\Table\SchedulesTable&\Cake\ORM\Association\BelongsTo $Schedules
 *
 * @method \App\Model\Entity\SeatReservation get($primaryKey, $options = [])
 * @method \App\Model\Entity\SeatReservation newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SeatReservation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SeatReservation|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SeatReservation saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SeatReservation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SeatReservation[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SeatReservation findOrCreate($search, callable $callback = null, $options = [])
 */
class SeatReservationsTable extends Table
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

        $this->setTable('seat_reservations');
        $this->setDisplayField('member_id');
        $this->setPrimaryKey(['member_id', 'schedule_id', 'column_number', 'record_number']);

        $this->belongsTo('Members', [
            'foreignKey' => 'member_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Schedules', [
            'foreignKey' => 'schedule_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Payments', [
            'foreignKey' => ['member_id', 'discount_id'],
            'joinType' => 'INNER',
        ]);
        $this->hasOne('ReservationDetail', [
            'foreignKey' => ['member_id', 'schedule_id', 'column_number', 'record_number'],
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
        $rules->add($rules->existsIn(['member_id'], 'Members'));
        $rules->add($rules->existsIn(['schedule_id'], 'Schedules'));

        return $rules;
    }
}
