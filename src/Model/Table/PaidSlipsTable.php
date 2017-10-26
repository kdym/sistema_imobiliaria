<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PaidSlips Model
 *
 * @property \App\Model\Table\ContractsTable|\Cake\ORM\Association\BelongsTo $Contracts
 *
 * @method \App\Model\Entity\PaidSlip get($primaryKey, $options = [])
 * @method \App\Model\Entity\PaidSlip newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PaidSlip[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PaidSlip|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PaidSlip patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PaidSlip[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PaidSlip findOrCreate($search, callable $callback = null, $options = [])
 */
class PaidSlipsTable extends Table
{

    const MULTIPLE_UNTIL = 'until';
    const MULTIPLE_PERIOD = 'period';

    public static $multipleOptions = [
        self::MULTIPLE_UNTIL => 'Pagar Até',
        self::MULTIPLE_PERIOD => 'Período',
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

        $this->setTable('paid_slips');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

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
            ->date('vencimento')
            ->allowEmpty('vencimento');

        $validator
            ->date('data_pago')
            ->allowEmpty('data_pago');

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
