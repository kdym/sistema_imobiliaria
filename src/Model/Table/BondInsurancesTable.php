<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BondInsurances Model
 *
 * @property \App\Model\Table\ContractsTable|\Cake\ORM\Association\BelongsTo $Contracts
 *
 * @method \App\Model\Entity\BondInsurance get($primaryKey, $options = [])
 * @method \App\Model\Entity\BondInsurance newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\BondInsurance[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BondInsurance|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BondInsurance patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\BondInsurance[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\BondInsurance findOrCreate($search, callable $callback = null, $options = [])
 */
class BondInsurancesTable extends Table
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

        $this->setTable('bond_insurances');
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
        $validator->add('vencimento', 'custom', [
            'rule' => function ($value, $context) {
                if (!empty($value)) {
                    $buffer = explode('/', $value);

                    return checkdate($buffer[1], $buffer[0], 2018);
                }
            },
            'message' => 'Valor inválido'
        ]);

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
