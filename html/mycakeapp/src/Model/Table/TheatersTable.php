<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Theaters Model
 *
 * @property \App\Model\Table\SchedulesTable&\Cake\ORM\Association\HasMany $Schedules
 *
 * @method \App\Model\Entity\Theater get($primaryKey, $options = [])
 * @method \App\Model\Entity\Theater newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Theater[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Theater|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Theater saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Theater patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Theater[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Theater findOrCreate($search, callable $callback = null, $options = [])
 */
class TheatersTable extends Table
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

        $this->setTable('theaters');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Schedules', [
            'foreignKey' => 'theater_id',
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
            ->scalar('file_name')
            ->maxLength('file_name', 100)
            ->requirePresence('file_name', 'create')
            ->notEmptyFile('file_name');

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
