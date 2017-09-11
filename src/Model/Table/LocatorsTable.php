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
 * Locators Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\Locator get($primaryKey, $options = [])
 * @method \App\Model\Entity\Locator newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Locator[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Locator|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Locator patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Locator[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Locator findOrCreate($search, callable $callback = null, $options = [])
 */
class LocatorsTable extends Table
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

        $this->setTable('locators');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Parser');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
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
        $validator->allowEmpty('cpf_conjuge');
        $validator->add('cpf_conjuge', 'validCep', [
            'rule' => ['custom', ValidationHelper::CPF_EXPRESSION],
            'message' => 'CPF inválido'
        ]);

        $validator->allowEmpty('data_nascimento_conjuge');
        $validator->add('data_nascimento_conjuge', [
            'date' => [
                'rule' => ['date', 'dmy'],
                'message' => 'Data inválida',
            ]
        ]);

        $validator->notEmpty('banco', 'Campo Obrigatório', function ($context) {
            return @$context['data']['em_maos'] == false;
        });

        $validator->notEmpty('agencia', 'Campo Obrigatório', function ($context) {
            return @$context['data']['em_maos'] == false;
        });

        $validator->notEmpty('conta', 'Campo Obrigatório', function ($context) {
            return @$context['data']['em_maos'] == false;
        });

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }

    public function beforeSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        if (!empty($entity['data_nascimento_conjuge'])) {
            $entity->set('data_nascimento_conjuge', $this->parseDate($entity['data_nascimento_conjuge']));
        }
    }
}
