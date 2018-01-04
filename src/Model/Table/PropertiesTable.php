<?php

namespace App\Model\Table;

use App\View\Helper\ValidationHelper;
use ArrayObject;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use SoftDelete\Model\Table\SoftDeleteTrait;

/**
 * Properties Model
 *
 * @property \App\Model\Table\LocatorsTable|\Cake\ORM\Association\BelongsTo $Locators
 * @property \App\Model\Table\PropertiesCompositionsTable|\Cake\ORM\Association\HasMany $PropertiesCompositions
 * @property \App\Model\Table\PropertiesFeesTable|\Cake\ORM\Association\HasMany $PropertiesFees
 * @property \App\Model\Table\PropertiesPricesTable|\Cake\ORM\Association\HasMany $PropertiesPrices
 *
 * @method \App\Model\Entity\Property get($primaryKey, $options = [])
 * @method \App\Model\Entity\Property newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Property[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Property|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Property patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Property[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Property findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PropertiesTable extends Table
{

    use SoftDeleteTrait;

    const TYPE_APARTMENT = 0;
    const TYPE_HOUSE = 1;
    const TYPE_SHOP = 2;
    const TYPE_TERRAIN = 3;
    const TYPE_COMERCIAL_SPOT = 4;
    const TYPE_RURAL_AREA = 5;
    const TYPE_ALLOTMENT = 6;
    const TYPE_OFFICE = 7;
    const TYPE_KITNET = 8;
    const TYPE_SHED = 9;

    public static $propertyTypes = [
        self::TYPE_APARTMENT => 'Apartamento',
        self::TYPE_HOUSE => 'Casa',
        self::TYPE_SHOP => 'Loja',
        self::TYPE_TERRAIN => 'Terreno',
        self::TYPE_COMERCIAL_SPOT => 'Ponto Comercial',
        self::TYPE_RURAL_AREA => 'Área Rural',
        self::TYPE_ALLOTMENT => 'Loteamento',
        self::TYPE_OFFICE => 'Sala Comercial',
        self::TYPE_KITNET => 'Kitnet',
        self::TYPE_SHED => 'Galpão',
    ];

    const MAX_CODE_CHARS = 5;

    const BILL_WATER = 'agua';

    public static $propertiesBills = [
        self::BILL_WATER => 'Água'
    ];

    public static $propertiesBillsIcons = [
        self::BILL_WATER => 'tint'
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

        $this->setTable('properties');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Parser');

        $this->belongsTo('Locators', [
            'foreignKey' => 'locator_id'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'broker'
        ]);
        $this->hasMany('PropertiesCompositions', [
            'foreignKey' => 'property_id',
            'sort' => ['id' => 'desc']
        ]);
        $this->hasMany('PropertiesFees', [
            'foreignKey' => 'property_id',
            'sort' => ['id' => 'desc']
        ]);
        $this->hasMany('PropertiesPrices', [
            'foreignKey' => 'property_id',
            'sort' => ['id' => 'desc']
        ]);
        $this->hasMany('PropertiesPhotos', [
            'foreignKey' => 'property_id',
            'sort' => ['ordem' => 'asc']
        ]);
        $this->hasMany('Contracts');
        $this->hasOne('ActiveContract', [
            'className' => 'Contracts',
            'foreignKey' => 'property_id',
            'conditions' => ['finalizado is null']
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
        $validator->notEmpty('cep');
        $validator->add('cep', 'validCep', [
            'rule' => ['custom', ValidationHelper::CEP_EXPRESSION],
            'message' => 'CEP inválido'
        ]);

        $validator->notEmpty('endereco');

        $validator->notEmpty('numero');

        $validator->notEmpty('bairro');

        $validator->notEmpty('cidade');

        $validator->notEmpty('uf');

        $validator->notEmpty('tipo');

        $validator->notEmpty('valor');

        $validator->notEmpty('taxa_administrativa_incidencia');

        $validator->notEmpty('taxa_administrativa_tipo');

        $validator->notEmpty('taxa_administrativa');

        $validator->notEmpty('locator_id');

        $validator->notEmpty('broker');

        foreach (self::$propertiesBills as $key => $b) {
            $validator->notEmpty("salary_$key", 'Campo Obrigatório', function ($context) use ($key) {
                return !empty($context['data'][$key]) && $context['data'][$key] == true;
            });
            $validator->add("salary_$key", 'range', [
                'rule' => ['range', 1, ContractsTable::DEFAULT_MONTH_DAYS],
                'message' => 'Dia inválido (1 a 30)'
            ]);
        }

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
        $rules->add($rules->existsIn(['locator_id'], 'Locators'));

        return $rules;
    }

    public function parseCode($code)
    {
        if (is_numeric($code)) {
            return (int)$code;
        } else {
            return $code;
        }
    }
}
