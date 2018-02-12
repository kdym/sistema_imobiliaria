<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Parameters Model
 *
 * @method \App\Model\Entity\Parameter get($primaryKey, $options = [])
 * @method \App\Model\Entity\Parameter newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Parameter[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Parameter|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Parameter patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Parameter[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Parameter findOrCreate($search, callable $callback = null, $options = [])
 */
class ParametersTable extends Table
{

    const MIN_WATER_RESIDENTIAL = 'min_water_residential';
    const MIN_WATER_NON_RESIDENTIAL = 'min_water_non_residential';

    public static $waterMinValues = [
        self::MIN_WATER_RESIDENTIAL => 'Residencial',
        self::MIN_WATER_NON_RESIDENTIAL => 'Não Residencial',
    ];

    const SLIP_LOCK = 'slip_lock';

    public static $parameters = [
        self::SLIP_LOCK => 'Trava do Boleto (dia)',
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

        $this->setTable('parameters');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Parser');
        $this->addBehavior('Formatter');
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
            ->scalar('nome')
            ->allowEmpty('nome');

        $validator
            ->scalar('valor')
            ->allowEmpty('valor');

        $validator
            ->date('start_date')
            ->allowEmpty('start_date');

        return $validator;
    }

    public function getParameter($name)
    {
        $parameter = $this->find()->where(['nome' => $name])->last();

        if ($parameter) {
            return $parameter['valor'];
        } else {
            return null;
        }
    }

    public function setParameter($name, $value)
    {
        $parameter = $this->newEntity();

        $parameter['nome'] = $name;
        $parameter['valor'] = $value;
        $parameter['start_date'] = date('Y-m-d');

        $this->save($parameter);
    }
}