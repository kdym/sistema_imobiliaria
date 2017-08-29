<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CompanyData Model
 *
 * @method \App\Model\Entity\CompanyData get($primaryKey, $options = [])
 * @method \App\Model\Entity\CompanyData newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CompanyData[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CompanyData|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CompanyData patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CompanyData[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CompanyData findOrCreate($search, callable $callback = null, $options = [])
 */
class CompanyDataTable extends Table
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

        $this->setTable('company_data');
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
            ->scalar('nome')
            ->requirePresence('nome', 'create')
            ->notEmpty('nome');

        $validator
            ->scalar('razao_social')
            ->requirePresence('razao_social', 'create')
            ->notEmpty('razao_social');

        $validator
            ->scalar('endereco')
            ->requirePresence('endereco', 'create')
            ->notEmpty('endereco');

        $validator
            ->scalar('numero')
            ->requirePresence('numero', 'create')
            ->notEmpty('numero');

        $validator
            ->scalar('complemento')
            ->requirePresence('complemento', 'create')
            ->notEmpty('complemento');

        $validator
            ->scalar('bairro')
            ->requirePresence('bairro', 'create')
            ->notEmpty('bairro');

        $validator
            ->scalar('cidade')
            ->requirePresence('cidade', 'create')
            ->notEmpty('cidade');

        $validator
            ->scalar('uf')
            ->requirePresence('uf', 'create')
            ->notEmpty('uf');

        $validator
            ->scalar('cep')
            ->requirePresence('cep', 'create')
            ->notEmpty('cep');

        $validator
            ->scalar('cnpj')
            ->requirePresence('cnpj', 'create')
            ->notEmpty('cnpj');

        $validator
            ->scalar('creci')
            ->requirePresence('creci', 'create')
            ->notEmpty('creci');

        $validator
            ->scalar('abadi')
            ->requirePresence('abadi', 'create')
            ->notEmpty('abadi');

        $validator
            ->scalar('telefone_1')
            ->requirePresence('telefone_1', 'create')
            ->notEmpty('telefone_1');

        $validator
            ->scalar('telefone_2')
            ->requirePresence('telefone_2', 'create')
            ->notEmpty('telefone_2');

        $validator
            ->scalar('telefone_3')
            ->requirePresence('telefone_3', 'create')
            ->notEmpty('telefone_3');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email');

        $validator
            ->scalar('latitude')
            ->requirePresence('latitude', 'create')
            ->notEmpty('latitude');

        $validator
            ->scalar('longitude')
            ->requirePresence('longitude', 'create')
            ->notEmpty('longitude');

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
        $rules->add($rules->isUnique(['email']));

        return $rules;
    }
}
