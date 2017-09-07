<?php

namespace App\Model\Table;

use App\View\Helper\ValidationHelper;
use ArrayObject;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use SoftDelete\Model\Table\SoftDeleteTrait;

/**
 * Users Model
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
{

    use SoftDeleteTrait;

    const ROLE_ADMIN = 0;
    const ROLE_BROKER = 1;
    const ROLE_LOCATOR = 2;
    const ROLE_TENANT = 3;

    public static $roles = [
        self::ROLE_ADMIN => 'Administrador',
        self::ROLE_BROKER => 'Corretor',
        self::ROLE_LOCATOR => 'Locador',
        self::ROLE_TENANT => 'Locatário',
    ];

    const MAX_PHONE_NUMBERS = 4;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasOne('Brokers');
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

        $validator->notEmpty('email');
        $validator->add('email', [
            "email" => [
                "rule" => "email"
            ]
        ]);

        $validator->notEmpty('role');

        $validator->notEmpty('username');

        $validator->notEmpty('password');

        $validator->notEmpty('new_password', 'Campo Obrigatório', function ($context) {
            return !empty($context['data']['change_password']) && $context['data']['change_password'] == true;
        });

        $validator->notEmpty('telefone_1');
        $validator->add('telefone_1', 'validPhone', [
            'rule' => ['custom', ValidationHelper::PHONE_DDD_EXPRESSION],
            'message' => 'Telefone inválido'
        ]);

        for ($i = 2; $i <= self::MAX_PHONE_NUMBERS; $i++) {
            $validator->allowEmpty("telefone_$i");
            $validator->add("telefone_$i", 'validPhone', [
                'rule' => ['custom', ValidationHelper::PHONE_DDD_EXPRESSION],
                'message' => 'Telefone inválido'
            ]);
        }


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
        $rules->add($rules->isUnique(['username'], 'Usuário já cadastrado com esse nome'));
        $rules->add($rules->isUnique(['email'], 'E-mail já cadastrado'));

        return $rules;
    }

    public function beforeSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {

        if (!empty($entity['password']) && empty($entity['id'])) {
            $entity->set('password', (new DefaultPasswordHasher)->hash($entity['password']));
        }

        if (!empty($entity['change_password']) && $entity['change_password'] == true) {
            $entity->set('password', (new DefaultPasswordHasher)->hash($entity['new_password']));
        }

        return true;
    }
}
