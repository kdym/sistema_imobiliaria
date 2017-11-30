<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LocatorsAssociations Model
 *
 * @method \App\Model\Entity\LocatorsAssociation get($primaryKey, $options = [])
 * @method \App\Model\Entity\LocatorsAssociation newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\LocatorsAssociation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LocatorsAssociation|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LocatorsAssociation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LocatorsAssociation[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\LocatorsAssociation findOrCreate($search, callable $callback = null, $options = [])
 */
class LocatorsAssociationsTable extends Table
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

        $this->setTable('locators_associations');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Locators', [
            'foreignKey' => 'locator_1',
        ]);
        $this->belongsTo('Properties');

        $this->belongsTo('Associateds', [
            'className' => 'Locators',
            'foreignKey' => 'locator_2',
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
            ->integer('locator_1')
            ->allowEmpty('locator_1');

        $validator
            ->integer('locator_2')
            ->allowEmpty('locator_2');

        $validator
            ->decimal('porcentagem')
            ->allowEmpty('porcentagem');

        return $validator;
    }
}
