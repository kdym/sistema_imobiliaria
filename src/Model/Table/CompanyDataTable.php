<?php

namespace App\Model\Table;

use App\View\Helper\ValidationHelper;
use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
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

        $this->addBehavior('GoogleMaps');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator->notEmpty('nome');
        $validator->notEmpty('razao_social');

        $validator->notEmpty('email');
        $validator->add('email', [
            "email" => [
                "rule" => "email"
            ]
        ]);

        $validator->notEmpty('cnpj');
        $validator->add('cnpj', 'validCnpj', [
            'rule' => ['custom', ValidationHelper::CNPJ_EXPRESSION],
            'message' => 'CNPJ inválido'
        ]);

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

        $validator->notEmpty('telefone_1');
        $validator->add('telefone_1', 'validPhone', [
            'rule' => ['custom', ValidationHelper::PHONE_DDD_EXPRESSION],
            'message' => 'Telefone inválido'
        ]);

        for ($i = 2; $i <= 3; $i++) {
            $validator->allowEmpty("telefone_$i");
            $validator->add("telefone_$i", 'validPhone', [
                'rule' => ['custom', ValidationHelper::PHONE_DDD_EXPRESSION],
                'message' => 'Telefone inválido'
            ]);
        }

        $validator->notEmpty('agencia');
        $validator->notEmpty('codigo_cedente');
        $validator->notEmpty('codigo_cedente_dv');

        $validator->notEmpty('logo', 'Campo Obrigatório', 'create');
        $validator->add('logo', [
            'extension' => [
                'rule' => ['extension', ['png']],
                'message' => 'Somente arquivos de imagem do tipo PNG'
            ]
        ]);

        $validator->allowEmpty('logo_small');
        $validator->add('logo_small', [
            'extension' => [
                'rule' => ['extension', ['png']],
                'message' => 'Somente arquivos de imagem do tipo PNG'
            ]
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
        $rules->add($rules->isUnique(['email']));

        return $rules;
    }

    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
        $geoInfo = $this->getGeoInfo(implode(' ', array_filter([
            $data['endereco'],
            $data['numero'],
            $data['complemento'],
            $data['bairro'],
            $data['cidade'],
            $data['uf'],
            $data['cep'],
        ])));

        $data['latitude'] = $geoInfo['latitude'];
        $data['longitude'] = $geoInfo['longitude'];
    }

    public function afterSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        $logoDir = WWW_ROOT . '/file';

        @mkdir($logoDir);

        if (!empty($entity['logo'])) {
            move_uploaded_file($entity['logo']['tmp_name'], sprintf('%s/logo.png', $logoDir));
        }

        if (!empty($entity['logo_small'])) {
            move_uploaded_file($entity['logo_small']['tmp_name'], sprintf('%s/logo_small.png', $logoDir));
        }
    }
}
