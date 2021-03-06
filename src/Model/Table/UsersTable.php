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
    const ROLE_PROSECUTOR = 4;
    const ROLE_GUARANTOR = 5;

    public static $roles = [
        self::ROLE_ADMIN => 'Administrador',
        self::ROLE_BROKER => 'Corretor',
        self::ROLE_LOCATOR => 'Locador',
        self::ROLE_TENANT => 'Locatário',
        self::ROLE_PROSECUTOR => 'Procurador',
        self::ROLE_GUARANTOR => 'Fiador',
    ];

    const MAX_PHONE_NUMBERS = 4;
    const MAX_PASSWORD_CHARS = 6;
    const MAX_USER_CHARS = 5;

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
        $this->addBehavior('Parser');

        $this->hasOne('Brokers');
        $this->hasOne('Locators');
        $this->hasOne('Spouses');
        $this->hasOne('Tenants');
        $this->hasMany('Prosecutors');
        $this->hasMany('Guarantors');
        $this->hasMany('Properties', [
            'foreignKey' => 'broker',
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

        $validator->notEmpty('cpf_cnpj');
        $validator->add('cpf_cnpj', 'custom', [
            'rule' => function ($value, $context) {
                if (!preg_match(ValidationHelper::CPF_EXPRESSION, $value) && !preg_match(ValidationHelper::CNPJ_EXPRESSION, $value)) {
                    return false;
                }

                return true;
            },
            'message' => 'CPF/CNPJ inválido'
        ]);

        $validator->notEmpty('data_nascimento');
        $validator->add('data_nascimento', [
            'date' => [
                'rule' => ['date', 'dmy'],
                'message' => 'Data inválida',
            ]
        ]);

        $validator->notEmpty('estado_civil');

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

        if (!empty($entity['data_nascimento'])) {
            $entity->set('data_nascimento', $this->parseDate($entity['data_nascimento']));
        }

        if (empty($entity['id'])) {
            $entity->set('codigo_unilar', $this->getRealEstateCode($entity));
        }

        return true;
    }

    public function getLastUsername()
    {
        $query = $this->find()->select(['max_user' => 'max(cast(username as unsigned))'])->first();

        return $query['max_user'];
    }

    public function generatePassword()
    {
        $characters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $buffer = str_split($characters);

        $buffer2 = "";
        for ($i = 0; $i < self::MAX_PASSWORD_CHARS; $i++) {
            $index = mt_rand(0, count($buffer) - 1);

            $buffer2 .= $buffer[$index];
        }

        return $buffer2;
    }

    public function parseUsername($username)
    {
        if (is_numeric($username)) {
            return (int)$username;
        } else {
            return $username;
        }
    }

    public function getRealEstateCode($entity)
    {
        $buffer = explode(' ', $entity->get('nome'));
        $firstNameLetter = strtoupper($this->removeSpecialChars(substr($buffer[0], 0, 1)));

        if (!empty($buffer[1])) {
            $secondNameLetter = strtoupper($this->removeSpecialChars(substr($buffer[1], 0, 1)));
        } else {
            $secondNameLetter = strtoupper($this->removeSpecialChars(substr($buffer[0], 1, 1)));
        }

        $firsCodePart = $firstNameLetter . $secondNameLetter;

        $lastCode = $this->find()
            ->where(['codigo_unilar like' => $firsCodePart . '%'])
            ->order(['codigo_unilar' => 'desc'])
            ->first();

        if ($lastCode) {
            $buffer = explode('-', $lastCode['codigo_unilar']);

            $secondCodePart = $buffer[1] + 1;
        } else {
            $secondCodePart = 1;
        }

        return sprintf('%s-%s', $firsCodePart, str_pad($secondCodePart, 2, '0', STR_PAD_LEFT));
    }

    public function removeSpecialChars($string)
    {
        return preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/"), explode(" ", "a A e E i I o O u U n N"), $string);
    }
}
