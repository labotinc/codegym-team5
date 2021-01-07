<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SlideshowPictures Model
 *
 * @property \App\Model\Table\MoviesTable&\Cake\ORM\Association\BelongsTo $Movies
 *
 * @method \App\Model\Entity\SlideshowPicture get($primaryKey, $options = [])
 * @method \App\Model\Entity\SlideshowPicture newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SlideshowPicture[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SlideshowPicture|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SlideshowPicture saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SlideshowPicture patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SlideshowPicture[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SlideshowPicture findOrCreate($search, callable $callback = null, $options = [])
 */
class SlideshowPicturesTable extends Table
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

        $this->setTable('slideshow_pictures');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Movies', [
            'foreignKey' => 'movie_id',
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
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('picture_name')
            ->maxLength('picture_name', 100)
            ->requirePresence('picture_name', 'create')
            ->notEmptyString('picture_name');

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

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['movie_id'], 'Movies'));

        return $rules;
    }
}
