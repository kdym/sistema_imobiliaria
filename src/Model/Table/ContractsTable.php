<?php

namespace App\Model\Table;

use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use DateTime;

/**
 * Contracts Model
 *
 * @property \App\Model\Table\TenantsTable|\Cake\ORM\Association\BelongsTo $Tenants
 * @property \App\Model\Table\PropertiesTable|\Cake\ORM\Association\BelongsTo $Properties
 * @property \App\Model\Table\ContractsValuesTable|\Cake\ORM\Association\HasMany $ContractsValues
 *
 * @method \App\Model\Entity\Contract get($primaryKey, $options = [])
 * @method \App\Model\Entity\Contract newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Contract[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Contract|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Contract patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Contract[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Contract findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ContractsTable extends Table
{

    const FINALITY_RESIDENTIAL = 0;
    const FINALITY_NON_RESIDENTIAL = 1;

    public static $finalities = [
        self::FINALITY_RESIDENTIAL => 'Residencial',
        self::FINALITY_NON_RESIDENTIAL => 'Não Residencial',
    ];

    const NO_WARRANTY = 0;
    const GUARANTOR = 1;

    public static $warranties = [
        self::GUARANTOR => 'Fiador',
        self::NO_WARRANTY => 'Sem Garantia',
    ];

    const DISCOUNT = 'discount';
    const FINE = 'fine';

    public static $discountOrFine = [
        self::DISCOUNT => 'Desconto Pagamento em Dia',
        self::FINE => 'Multa por Atraso',
    ];

    const RENT = 'rent';
    const CUSTOM_FEE = 'custom';

    public static $feesNames = [
        self::RENT => 'Aluguel',
        self::CUSTOM_FEE => 'Taxa Extra',
    ];

    const DEFAULT_MONTH_DAYS = 30;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('contracts');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Parser');

        $this->belongsTo('Tenants', [
            'foreignKey' => 'tenant_id'
        ]);
        $this->belongsTo('Properties', [
            'foreignKey' => 'property_id'
        ]);
        $this->hasMany('ContractsValues', [
            'foreignKey' => 'contract_id',
            'sort' => ['id' => 'desc']
        ]);
        $this->hasMany('Guarantors', [
            'foreignKey' => 'contract_id',
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
        $validator->add('tenant', 'hasTenant', [
            'rule' => function ($value, $context) {
                return !empty($context['data']['tenant_id']);
            },
            'message' => 'É necessário buscar um Locatário'
        ]);

        $validator->add('property', 'hasProperty', [
            'rule' => function ($value, $context) {
                return !empty($context['data']['property_id']);
            },
            'message' => 'É necessário buscar um Imóvel'
        ]);
        $validator->add('property', 'hasContract', [
            'rule' => function ($value, $context) {
                $hasContract = $this->find()
                    ->where(['property_id' => $context['data']['property_id']])
                    ->where(['finalizado is not null'])
                    ->first();

                return empty($hasContract);
            },
            'message' => 'Esse imóvel já possui um Contrato ativo'
        ]);

        $validator->notEmpty('data_inicio');
        $validator->add('data_inicio', [
            'date' => [
                'rule' => ['date', 'dmy'],
                'message' => 'Data inválida',
            ]
        ]);

        $validator->notEmpty('isencao');

//        $validator->notEmpty('data_fim', 'Campo Obrigatório');
//        $validator->add('data_fim', [
//            'date' => [
//                'rule' => ['date', 'dmy'],
//                'message' => 'Data inválida',
//            ]
//        ]);
//        $validator->add('data_fim', 'custom', [
//            'rule' => function ($value, $context) {
//                $startDate = new DateTime($this->parseDate($context['data']['data_inicio']));
//                $endDate = new DateTime($this->parseDate($value));
//
//                return $startDate < $endDate;
//            },
//            'message' => 'Deve ser maior que a Data de Início'
//        ]);

        $validator->notEmpty('dia_vencimento', 'Campo Obrigatório', 'update');
        $validator->add('dia_vencimento', 'range', [
            'rule' => ['range', 1, self::DEFAULT_MONTH_DAYS],
            'message' => 'Dia inválido (1 a 30)'
        ]);

        $validator->notEmpty('primeiro_vencimento');
        $validator->add('primeiro_vencimento', 'custom', [
            'rule' => function ($value, $context) {
                $startDate = new DateTime($this->parseDate($context['data']['data_inicio']));
                $firstSalary = new DateTime($this->parseDate($value));

                return $firstSalary >= $startDate;
            },
            'message' => 'Fora do Período do Contrato'
        ]);

        $validator->allowEmpty('data_posse');
        $validator->add('data_posse', 'custom', [
            'rule' => function ($value, $context) {
                $startDate = new DateTime($this->parseDate($context['data']['data_inicio']));
                $ownDate = new DateTime($this->parseDate($value));

                return $ownDate >= $startDate;
            },
            'message' => 'Fora do Período do Contrato'
        ]);

        $validator->notEmpty('finalidade');

        $validator->notEmpty('finalidade_nao_residencial', 'Campo Obrigatório', function ($context) {
            return !empty($context['data']['finalidade']) && $context['data']['finalidade'] == self::FINALITY_NON_RESIDENTIAL;
        });

        $validator->notEmpty('tipo_garantia');

        $validator->notEmpty('taxa_contratual');

        $validator->notEmpty('discount_fine_choice');

        $validator->notEmpty('discount_fine');

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
        $rules->add($rules->existsIn(['tenant_id'], 'Tenants'));
        $rules->add($rules->existsIn(['property_id'], 'Properties'));

        return $rules;
    }

    public function beforeSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {

        if (!empty($entity['period'])) {
            $period = explode(' a ', $entity['period']);

            $entity->set('data_inicio', $this->parseDate($period[0]));
            $entity->set('data_fim', $this->parseDate($period[1]));
        }

        return true;
    }
}
