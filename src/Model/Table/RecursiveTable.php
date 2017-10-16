<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Recursive Model
 *
 * @property \App\Model\Table\SlipsCustomsValuesTable|\Cake\ORM\Association\HasMany $SlipsCustomsValues
 *
 * @method \App\Model\Entity\Recursive get($primaryKey, $options = [])
 * @method \App\Model\Entity\Recursive newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Recursive[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Recursive|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Recursive patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Recursive[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Recursive findOrCreate($search, callable $callback = null, $options = [])
 */
class RecursiveTable extends Table
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

        $this->setTable('recursive');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasOne('SlipsCustomsValues', [
            'foreignKey' => 'recursive_id'
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
            ->scalar('dia')
            ->allowEmpty('dia');

        $validator
            ->scalar('mes')
            ->allowEmpty('mes');

        $validator
            ->scalar('ano')
            ->allowEmpty('ano');

        $validator
            ->date('start_date')
            ->allowEmpty('start_date');

        $validator
            ->date('end_date')
            ->allowEmpty('end_date');

        return $validator;
    }
}
