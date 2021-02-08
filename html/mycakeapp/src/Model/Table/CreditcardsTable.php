<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Database\Schema\TableSchema as Schema;

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
        $validator->provider('custom', 'App\Model\Validation\CustomValidation');
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('card_number')
            ->maxLength('card_number', 100)
            ->creditCard('card_number', 'all', '不正なカード番号です')
            ->requirePresence('card_number', 'create')
            ->integer('card_number', '半角数字以外の文字が使われています')
            ->notEmptyString('card_number', '空白になっています')
            ->add('card_number', 'ruleName', [
                'rule' => ['NotBlankOnly'],
                'provider' => 'custom',
                'message' => '空白になっています'
            ]);

        $validator
            ->scalar('name')
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->notEmptyString('name', '空白になっています')
            ->add('name', 'ruleName', [
                'rule' => ['NotBlankOnly'],
                'provider' => 'custom',
                'message' => '空白になっています'
            ])
            ->add('name', 'ruleName', [
                'rule' => ['HalfSizeAlphabetAndSpaceOnly'],
                'provider' => 'custom',
                'message' => '半角英字以外の文字が使われています'
            ]);

        $validator
            ->integer('deadline')
            ->requirePresence('deadline', 'create')
            ->integer('deadline', '半角数字以外の文字が使われています')
            ->notEmptyString('deadline', '空白になっています')
            ->add('deadline', 'ruleName', [
                'rule' => ['NotBlankOnly'],
                'provider' => 'custom',
                'message' => '空白になっています'
            ]);

        $validator
            ->integer('security_code')
            ->requirePresence('security_code', true, '空白になっています')
            ->integer('security_code', '半角数字以外の文字が使われています')
            ->notEmptyString('security_code', '空白になっています')
            ->add('security_code', 'ruleName', [
                'rule' => ['NotBlankOnly'],
                'provider' => 'custom',
                'message' => '空白になっています'
            ]);

        $validator
            ->boolean('is_deleted')
            ->notEmptyString('is_deleted');

        $validator
            ->requirePresence('accept', true, '利用規約に同意しなければ、登録することはできません')
            ->notEmptyString('accept', '利用規約に同意しなければ、登録することはできません');

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
        $rules->add(
            function ($entity, $options) use ($rules) {
                // 削除済データの場合は重複チェックはしない
                if ($entity->deleted === true) {
                    return true;
                }
                //  card_number と deleted の組み合わせで重複チェック
                $rule = $rules->isUnique(
                    ['card_number', 'is_deleted'],
                    'このクレジットカードは利用できません'
                );
                return $rule($entity, $options);
            }
        );
        return $rules;
    }
    protected function _initializeSchema(Schema $schema)
    {
        parent::_initializeSchema($schema);
        $schema->columnType('card_number', 'EncryptedType');
        return $schema;
    }
}
