<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SlipsCustomsValues Model
 *
 * @property \App\Model\Table\ContractsTable|\Cake\ORM\Association\BelongsTo $Contracts
 *
 * @method \App\Model\Entity\SlipsCustomsValue get($primaryKey, $options = [])
 * @method \App\Model\Entity\SlipsCustomsValue newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SlipsCustomsValue[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SlipsCustomsValue|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SlipsCustomsValue patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SlipsCustomsValue[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SlipsCustomsValue findOrCreate($search, callable $callback = null, $options = [])
 */
class SlipsCustomsValuesTable extends Table
{

    const RENT = 'rent';
    const CUSTOM = 'custom';

    public static $values = [
        self::RENT => 'Aluguel',
        self::CUSTOM => 'Taxa Extra',
    ];

    const RECURSIVE_ALL = 'all';
    const RECURSIVE_START_AT = 'start_at';
    const RECURSIVE_PERIOD = 'period';

    public static $recursiveOptions = [
        self::RECURSIVE_ALL => 'Todos os Boletos',
        self::RECURSIVE_START_AT => 'A partir de',
        self::RECURSIVE_PERIOD => 'Período',
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

        $this->setTable('slips_custom_values');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Contracts', [
            'foreignKey' => 'contract_id'
        ]);
        $this->hasMany('SlipsRecursive', [
            'foreignKey' => 'slip_custom_id',
            'sort' => ['id' => 'desc'],
        ]);

        $this->addBehavior('Parser');
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
            ->integer('tipo')
            ->allowEmpty('tipo');

        $validator
            ->integer('mes')
            ->allowEmpty('mes');

        $validator
            ->integer('ano')
            ->allowEmpty('ano');

        $validator
            ->scalar('descricao')
            ->allowEmpty('descricao');

        $validator
            ->decimal('valor')
            ->allowEmpty('valor');

        $validator
            ->boolean('deleted')
            ->allowEmpty('deleted');

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
        $rules->add($rules->existsIn(['contract_id'], 'Contracts'));

        return $rules;
    }
}
