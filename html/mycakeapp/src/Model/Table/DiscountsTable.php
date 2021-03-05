<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Discounts Model
 *
 * @property \App\Model\Table\ReservationDetailsTable&\Cake\ORM\Association\HasMany $ReservationDetails
 *
 * @method \App\Model\Entity\Discount get($primaryKey, $options = [])
 * @method \App\Model\Entity\Discount newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Discount[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Discount|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Discount saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Discount patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Discount[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Discount findOrCreate($search, callable $callback = null, $options = [])
 */
class DiscountsTable extends Table
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

        $this->setTable('discounts');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('ReservationDetails', [
            'foreignKey' => 'discount_id',
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
            ->scalar('detail')
            ->maxLength('detail', 1000)
            ->requirePresence('detail', 'create')
            ->notEmptyString('detail');

        $validator
            ->scalar('picture_name')
            ->maxLength('picture_name', 100)
            ->requirePresence('picture_name', 'create')
            ->notEmptyString('picture_name');

        $validator
            ->integer('displayed_amount')
            ->requirePresence('displayed_amount', 'create')
            ->notEmptyString('displayed_amount');

        $validator
            ->dateTime('started_at')
            ->requirePresence('started_at', 'create')
            ->notEmptyDateTime('started_at');

        $validator
            ->dateTime('finished_at')
            ->requirePresence('finished_at', 'create')
            ->notEmptyDateTime('finished_at');

        $validator
            ->boolean('is_minus')
            ->notEmptyString('is_minus');

        $validator
            ->boolean('is_everyone')
            ->notEmptyString('is_everyone');

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
    public function findUseDiscountDetail(Query $query, array $options)
    {
        $useDiscountSql = $query
            ->select(['displayed_amount', 'name', 'is_minus'])
            ->where([
                'id' => $_SESSION['payment']['discount_id'],
                'started_at <=' => $options['start_date'],
                'OR' => [['finished_at >=' => $options['start_date']], ['finished_at IS NULL']],
                'is_deleted' => 0,

            ])->hydrate(false)->first();
        return $useDiscountSql;
    }
}
