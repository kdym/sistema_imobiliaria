<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CustomBills Model
 *
 * @property \App\Model\Table\ReferencesTable|\Cake\ORM\Association\BelongsTo $References
 *
 * @method \App\Model\Entity\CustomBill get($primaryKey, $options = [])
 * @method \App\Model\Entity\CustomBill newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CustomBill[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CustomBill|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CustomBill patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CustomBill[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CustomBill findOrCreate($search, callable $callback = null, $options = [])
 */
class CustomBillsTable extends Table
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

        $this->setTable('custom_bills');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
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
            ->integer('categoria')
            ->allowEmpty('categoria');

        $validator
            ->scalar('descricao')
            ->allowEmpty('descricao');

        $validator
            ->integer('pagante')
            ->allowEmpty('pagante');

        $validator
            ->integer('recebedor')
            ->allowEmpty('recebedor');

        $validator
            ->scalar('repeat_year')
            ->allowEmpty('repeat_year');

        $validator
            ->scalar('repeat_month')
            ->allowEmpty('repeat_month');

        $validator
            ->scalar('repeat_day')
            ->allowEmpty('repeat_day');

        $validator
            ->date('data_inicio')
            ->allowEmpty('data_inicio');

        $validator
            ->date('data_fim')
            ->allowEmpty('data_fim');

        $validator
            ->decimal('valor')
            ->allowEmpty('valor');

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

        return $rules;
    }
}
