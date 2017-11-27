<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BillsTransactions Model
 *
 * @property \App\Model\Table\ReferencesTable|\Cake\ORM\Association\BelongsTo $References
 *
 * @method \App\Model\Entity\BillsTransaction get($primaryKey, $options = [])
 * @method \App\Model\Entity\BillsTransaction newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\BillsTransaction[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BillsTransaction|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BillsTransaction patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\BillsTransaction[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\BillsTransaction findOrCreate($search, callable $callback = null, $options = [])
 */
class BillsTransactionsTable extends Table
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

        $this->setTable('bills_transactions');
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
            ->date('data_pago')
            ->allowEmpty('data_pago');

        $validator
            ->date('data_vencimento')
            ->allowEmpty('data_vencimento');

        $validator
            ->decimal('valor')
            ->allowEmpty('valor');

        $validator
            ->boolean('ausente')
            ->allowEmpty('ausente');

        $validator
            ->date('debitada')
            ->allowEmpty('debitada');

        $validator
            ->decimal('diferenca')
            ->allowEmpty('diferenca');

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
