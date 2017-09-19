<?php

namespace App\Model\Table;

use ArrayObject;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PropertiesFees Model
 *
 * @property \App\Model\Table\PropertiesTable|\Cake\ORM\Association\BelongsTo $Properties
 *
 * @method \App\Model\Entity\PropertiesFee get($primaryKey, $options = [])
 * @method \App\Model\Entity\PropertiesFee newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PropertiesFee[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PropertiesFee|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PropertiesFee patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PropertiesFee[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PropertiesFee findOrCreate($search, callable $callback = null, $options = [])
 */
class PropertiesFeesTable extends Table
{

    const INCIDENCE_RENT = 0;
    const INCIDENCE_TOTAL = 1;

    public static $incidences = [
        self::INCIDENCE_RENT => 'Sobre o Aluguel',
        self::INCIDENCE_TOTAL => 'Sobre o Total',
    ];

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('properties_fees');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Parser');

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
            ->decimal('taxa_administrativa')
            ->allowEmpty('taxa_administrativa');

        $validator
            ->integer('taxa_administrativa_tipo')
            ->allowEmpty('taxa_administrativa_tipo');

        $validator
            ->integer('taxa_administrativa_incidencia')
            ->allowEmpty('taxa_administrativa_incidencia');

        $validator
            ->integer('parcelas_13_taxa_administrativa')
            ->allowEmpty('parcelas_13_taxa_administrativa');

        $validator
            ->date('start_date')
            ->allowEmpty('start_date');

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

    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
        if (!empty($data['taxa_administrativa'])) {
            $data['taxa_administrativa'] = $this->parseDecimal($data['taxa_administrativa']);
        }
    }
}
