<?php
namespace App\Model\Table;

use App\View\Helper\ValidationHelper;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Spouses Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\Spouse get($primaryKey, $options = [])
 * @method \App\Model\Entity\Spouse newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Spouse[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Spouse|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Spouse patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Spouse[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Spouse findOrCreate($search, callable $callback = null, $options = [])
 */
class SpousesTable extends Table
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

        $this->setTable('spouses');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
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
        $validator->allowEmpty('cpf');
        $validator->add('cpf', 'validCep', [
            'rule' => ['custom', ValidationHelper::CPF_EXPRESSION],
            'message' => 'CPF inválido'
        ]);

        $validator->allowEmpty('data_nascimento');
        $validator->add('data_nascimento', [
            'date' => [
                'rule' => ['date', 'dmy'],
                'message' => 'Data inválida',
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
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
