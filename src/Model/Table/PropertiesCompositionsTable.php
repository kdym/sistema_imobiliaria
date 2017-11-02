<?php

namespace App\Model\Table;

use App\Model\Custom\PropertyItem;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PropertiesCompositions Model
 *
 * @property \App\Model\Table\PropertiesTable|\Cake\ORM\Association\BelongsTo $Properties
 *
 * @method \App\Model\Entity\PropertiesComposition get($primaryKey, $options = [])
 * @method \App\Model\Entity\PropertiesComposition newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PropertiesComposition[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PropertiesComposition|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PropertiesComposition patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PropertiesComposition[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PropertiesComposition findOrCreate($search, callable $callback = null, $options = [])
 */
class PropertiesCompositionsTable extends Table
{

    const GATED_COMMUNITY = 'condominio_fechado';
    const POOL = 'piscina';
    const PARTY_ROOM = 'salao_festas';
    const BARBECUE_AREA = 'area_churrasqueira';
    const SERVICE_AREA = 'area_servico';
    const MAID_QUARTERS = 'dependencias_empregada';
    const BALCONY = 'varanda';
    const BACKYARD = 'quintal';
    const TERRACE = 'terraco';
    const SAUNA = 'sauna';

    public static $compositions = [
        self::GATED_COMMUNITY => 'Condomínio Fechado',
        self::POOL => 'Piscina',
        self::PARTY_ROOM => 'Salão de Festas',
        self::BARBECUE_AREA => 'Área de Churrasqueira',
        self::SERVICE_AREA => 'Área de Serviço',
        self::MAID_QUARTERS => 'Dependências de Empregada',
        self::BALCONY => 'Varanda',
        self::BACKYARD => 'Quintal',
        self::TERRACE => 'Terraço',
        self::SAUNA => 'Sauna',
    ];

    const BEDROOMS = 'quartos';
    const SUITES = 'suites';
    const GARAGES = 'garagens';
    const RESTROOMS = 'banheiros';
    const ROOMS = 'salas';
    const KITCHENS = 'cozinhas';

    public static $propertiesItems = [];

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('properties_compositions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->loadPropertiesItems();

        $this->belongsTo('Properties', [
            'foreignKey' => 'property_id'
        ]);
    }

    public function loadPropertiesItems() {
        $item = new PropertyItem();

        $item->setKey(self::BEDROOMS);
        $item->setName('Quartos');
        $item->setIcon('bed');

        self::$propertiesItems[] = $item;

        $item = new PropertyItem();

        $item->setKey(self::SUITES);
        $item->setName('Suítes');
        $item->setIcon('bath');

        self::$propertiesItems[] = $item;

        $item = new PropertyItem();

        $item->setKey(self::GARAGES);
        $item->setName('Garagens');
        $item->setIcon('car');

        self::$propertiesItems[] = $item;

        $item = new PropertyItem();

        $item->setKey(self::RESTROOMS);
        $item->setName('Banheiros');
        $item->setIcon('bath');

        self::$propertiesItems[] = $item;

        $item = new PropertyItem();

        $item->setKey(self::ROOMS);
        $item->setName('Salas');
        $item->setIcon('square-o');

        self::$propertiesItems[] = $item;

        $item = new PropertyItem();

        $item->setKey(self::KITCHENS);
        $item->setName('Cozinhas');
        $item->setIcon('cutlery');

        self::$propertiesItems[] = $item;
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
            ->integer('quartos')
            ->allowEmpty('quartos');

        $validator
            ->integer('suites')
            ->allowEmpty('suites');

        $validator
            ->integer('garagens')
            ->allowEmpty('garagens');

        $validator
            ->boolean('condominio_fechado')
            ->allowEmpty('condominio_fechado');

        $validator
            ->boolean('piscina')
            ->allowEmpty('piscina');

        $validator
            ->boolean('salao_festas')
            ->allowEmpty('salao_festas');

        $validator
            ->boolean('area_churrasqueira')
            ->allowEmpty('area_churrasqueira');

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
}
