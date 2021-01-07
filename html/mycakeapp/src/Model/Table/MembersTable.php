<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Members Model
 *
 * @property \App\Model\Table\CreditcardsTable&\Cake\ORM\Association\HasMany $Creditcards
 * @property \App\Model\Table\PaymentsTable&\Cake\ORM\Association\HasMany $Payments
 * @property \App\Model\Table\PointsTable&\Cake\ORM\Association\HasMany $Points
 * @property \App\Model\Table\ReservationDetailsTable&\Cake\ORM\Association\HasMany $ReservationDetails
 * @property \App\Model\Table\SeatReservationsTable&\Cake\ORM\Association\HasMany $SeatReservations
 *
 * @method \App\Model\Entity\Member get($primaryKey, $options = [])
 * @method \App\Model\Entity\Member newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Member[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Member|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Member saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Member patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Member[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Member findOrCreate($search, callable $callback = null, $options = [])
 */
class MembersTable extends Table
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

        $this->setTable('members');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('Creditcards', [
            'foreignKey' => 'member_id',
        ]);
        $this->hasMany('Payments', [
            'foreignKey' => 'member_id',
        ]);
        $this->hasMany('Points', [
            'foreignKey' => 'member_id',
        ]);
        $this->hasMany('ReservationDetails', [
            'foreignKey' => 'member_id',
        ]);
        $this->hasMany('SeatReservations', [
            'foreignKey' => 'member_id',
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
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email');

        $validator
            ->scalar('password')
            ->maxLength('password', 100)
            ->requirePresence('password', 'create')
            ->notEmptyString('password');

        $validator
            ->integer('total_point')
            ->requirePresence('total_point', 'create')
            ->notEmptyString('total_point');

        $validator
            ->boolean('is_deleted')
            ->requirePresence('is_deleted', 'create')
            ->notEmptyString('is_deleted');

        $validator
            ->boolean('is_provisional')
            ->notEmptyString('is_provisional');

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
        $rules->add($rules->isUnique(['email']));

        return $rules;
    }
}
