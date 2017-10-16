<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SlipsRecursive Model
 *
 * @property \App\Model\Table\SlipsCustomValuesTable|\Cake\ORM\Association\BelongsTo $SlipsCustomValues
 * @property \App\Model\Table\ContractsTable|\Cake\ORM\Association\BelongsTo $Contracts
 *
 * @method \App\Model\Entity\SlipsRecursive get($primaryKey, $options = [])
 * @method \App\Model\Entity\SlipsRecursive newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SlipsRecursive[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SlipsRecursive|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SlipsRecursive patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SlipsRecursive[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SlipsRecursive findOrCreate($search, callable $callback = null, $options = [])
 */
class SlipsRecursiveTable extends Table
{

    const RECURSION_ALL = 'all';
    const RECURSION_START_AT = 'start_at';
    const RECURSION_PERIOD = 'period';
    const RECURSION_NONE = 'none';

    public static $recursiveOptions = [
        self::RECURSION_ALL => 'Todos os Boletos',
        self::RECURSION_START_AT => 'A partir de',
        self::RECURSION_PERIOD => 'Período',
        self::RECURSION_NONE => 'Sem Recursividade',
    ];

    const DELETE_ALL = 'delete_all';
    const DELETE_SINGLE = 'delete_single';
    const DELETE_NEXT = 'delete_next';

    public static $deleteOptions = [
        self::DELETE_SINGLE => 'Excluir somente esse',
        self::DELETE_NEXT => 'Excluir desse em diante',
        self::DELETE_ALL => 'Excluir todos',
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

        $this->setTable('slips_recursive');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('SlipsCustomValues', [
            'foreignKey' => 'slip_custom_id'
        ]);
        $this->belongsTo('Contracts', [
            'foreignKey' => 'contract_id'
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
            ->date('start_date')
            ->allowEmpty('start_date');

        $validator
            ->date('end_date')
            ->allowEmpty('end_date');

        $validator
            ->boolean('deleted')
            ->allowEmpty('deleted');

        $validator
            ->scalar('tipo')
            ->allowEmpty('tipo');

        $validator
            ->decimal('valor')
            ->requirePresence('valor', 'create')
            ->notEmpty('valor');

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
