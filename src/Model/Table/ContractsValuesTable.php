<?php

namespace App\Model\Table;

use App\Model\Custom\GeneralFee;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ContractsValues Model
 *
 * @property \App\Model\Table\ContractsTable|\Cake\ORM\Association\BelongsTo $Contracts
 *
 * @method \App\Model\Entity\ContractsValue get($primaryKey, $options = [])
 * @method \App\Model\Entity\ContractsValue newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ContractsValue[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ContractsValue|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ContractsValue patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ContractsValue[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ContractsValue findOrCreate($search, callable $callback = null, $options = [])
 */
class ContractsValuesTable extends Table
{

    const RECORD_FEE = 'taxa_expediente';
    const CPMF = 'cpmf';
    const MAIL_FEE = 'taxa_correio';

    public static $fees = [
        self::RECORD_FEE => 'Taxa de Expediente',
        self::CPMF => 'CPMF',
        self::MAIL_FEE => 'Taxa de Correio',
    ];

    public static $feesIcons = [
        self::RECORD_FEE => 'barcode',
        self::CPMF => 'percent',
        self::MAIL_FEE => 'envelope',
    ];

    public static $generalFees = [];

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('contracts_values');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->loadGeneralFees();

        $this->belongsTo('Contracts', [
            'foreignKey' => 'contract_id',
            'joinType' => 'INNER'
        ]);
    }

    public function loadGeneralFees()
    {
        $fee = new GeneralFee();

        $fee->setKey(self::RECORD_FEE);
        $fee->setName('Taxa de Expediente');
        $fee->setIcon('barcode');
        $fee->setType(GeneralFee::CURRENCY);

        self::$generalFees[] = $fee;

        $fee = new GeneralFee();

        $fee->setKey(self::CPMF);
        $fee->setName('CPMF');
        $fee->setIcon('percent');
        $fee->setType(GeneralFee::PERCENT);

        self::$generalFees[] = $fee;

        $fee = new GeneralFee();

        $fee->setKey(self::MAIL_FEE);
        $fee->setName('Taxa de Correio');
        $fee->setIcon('envelope');
        $fee->setType(GeneralFee::CURRENCY);

        self::$generalFees[] = $fee;
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
            ->requirePresence('start_date', 'create')
            ->notEmpty('start_date');

        $validator
            ->integer('finalidade')
            ->requirePresence('finalidade', 'create')
            ->notEmpty('finalidade');

        $validator
            ->scalar('finalidade_nao_residencial')
            ->requirePresence('finalidade_nao_residencial', 'create')
            ->notEmpty('finalidade_nao_residencial');

        $validator
            ->integer('vencimento_boletos')
            ->requirePresence('vencimento_boletos', 'create')
            ->notEmpty('vencimento_boletos');

        $validator
            ->decimal('taxa_contratual')
            ->requirePresence('taxa_contratual', 'create')
            ->notEmpty('taxa_contratual');

        $validator
            ->decimal('desconto')
            ->requirePresence('desconto', 'create')
            ->notEmpty('desconto');

        $validator
            ->decimal('multa')
            ->requirePresence('multa', 'create')
            ->notEmpty('multa');

        $validator
            ->boolean('taxa_expediente')
            ->requirePresence('taxa_expediente', 'create')
            ->notEmpty('taxa_expediente');

        $validator
            ->boolean('cpmf')
            ->requirePresence('cpmf', 'create')
            ->notEmpty('cpmf');

        $validator
            ->boolean('taxa_correio')
            ->requirePresence('taxa_correio', 'create')
            ->notEmpty('taxa_correio');

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
