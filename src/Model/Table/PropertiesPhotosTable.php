<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PropertiesPhotos Model
 *
 * @property \App\Model\Table\PropertiesTable|\Cake\ORM\Association\BelongsTo $Properties
 *
 * @method \App\Model\Entity\PropertiesPhoto get($primaryKey, $options = [])
 * @method \App\Model\Entity\PropertiesPhoto newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PropertiesPhoto[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PropertiesPhoto|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PropertiesPhoto patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PropertiesPhoto[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PropertiesPhoto findOrCreate($search, callable $callback = null, $options = [])
 */
class PropertiesPhotosTable extends Table
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

        $this->setTable('properties_photos');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Properties', [
            'foreignKey' => 'property_id'
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
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('url')
            ->allowEmpty('url');

        $validator
            ->integer('ordem')
            ->allowEmpty('ordem');

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
        $rules->add($rules->existsIn(['property_id'], 'Properties'));

        return $rules;
    }
}
