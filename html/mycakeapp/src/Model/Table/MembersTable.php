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

        $this->hasMany('Payments', [
            'foreignKey' => 'member_id',
        ]);
        $this->hasMany('ReservationDetails', [
            'foreignKey' => 'member_id',
        ]);
        $this->hasMany('SeatReservations', [
            'foreignKey' => 'member_id',
        ]);
        $this->hasMany('Creditcards', [
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
        $validator->provider('custom', 'App\Model\Validation\CustomValidation');
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');
        $validator
            ->email('email', false, 'メールアドレスが間違っているようです')
            ->requirePresence('email', 'create')
            ->notEmptyString('email', '空白になっています')
            ->add('email', 'ruleName', [
                'rule' => ['NotBlankOnly'],
                'provider' => 'custom',
                'message' => '空白になっています'
            ]);

        $validator
            ->scalar('password')
            ->minLength('password', 4, 'パスワードは4文字以上13文字以下にしてください')
            ->maxLength('password', 13, 'パスワードは4文字以上13文字以下にしてください')
            ->requirePresence('password', 'create')
            ->notEmptyString('password', '空白になっています')
            ->add('password', 'NotBlankOnly', [
                'rule' => ['NotBlankOnly'],
                'provider' => 'custom',
                'message' => '空白になっています'
            ])
            ->add('password', 'HalfSizeAlphanumericOnly', [
                'rule' => ['HalfSizeAlphanumericOnly'],
                'provider' => 'custom',
                'message' => 'パスワードに使えない文字が入力されています'
            ]);
        $validator
            ->scalar('rePassword')
            ->minLength('rePassword', 4, 'パスワードは4文字以上13文字以下にしてください')
            ->maxLength('rePassword', 13, 'パスワードは4文字以上13文字以下にしてください')
            ->requirePresence('rePassword', 'create')
            ->notEmptyString('rePassword', '空白になっています')
            ->sameAs('rePassword', 'password', 'パスワードが一致していません')
            ->add('rePassword', 'NotBlankOnly', [
                'rule' => ['NotBlankOnly'],
                'provider' => 'custom',
                'message' => '空白になっています'
            ])
            ->add('rePassword', 'HalfSizeAlphanumericOnly', [
                'rule' => ['HalfSizeAlphanumericOnly'],
                'provider' => 'custom',
                'message' => 'パスワードに使えない文字が入力されています'
            ]);

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
    public function validationLogin($validator)
    {
        $validator->provider('custom', 'App\Model\Validation\CustomValidation');
        $validator
            ->email('email', false, 'メールアドレスが間違っているようです')
            ->requirePresence('email', 'create')
            ->notEmptyString('email','空白になっています')
            ->add('email', 'ruleName', [
                'rule' => ['NotBlankOnly'],
                'provider' => 'custom',
                'message' => '空白になっています'
            ]);
        $validator
            ->scalar('password')
            ->requirePresence('password', 'create')
            ->notEmptyString('password', '空白になっています')
            ->add('password', 'NotBlankOnly', [
                'rule' => ['NotBlankOnly'],
                'provider' => 'custom',
                'message' => '空白になっています'
            ]);

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
        $rules->add($rules->isUnique(['email'], 'このメールアドレスはすでに利用されています'));

        return $rules;
    }
}
