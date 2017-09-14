<?php

namespace App\Model\Entity;

use App\Model\Table\UsersTable;
use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string $nome
 * @property string $username
 * @property string $password
 * @property string $email
 * @property int $role
 * @property \Cake\I18n\FrozenTime $created
 * @property string $endereco
 * @property string $numero
 * @property string $complemento
 * @property string $bairro
 * @property string $cidade
 * @property string $uf
 * @property string $cep
 * @property string $identidade
 * @property string $cpf_cnpj
 * @property int $estado_civil
 * @property string $telefone_1
 * @property string $telefone_2
 * @property string $telefone_3
 * @property string $telefone_4
 * @property \Cake\I18n\FrozenDate $data_nascimento
 * @property string $avatar
 * @property bool $deleted
 */
class User extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];

    protected function _getFormattedUsername()
    {
        if (is_numeric($this['username'])) {
            return str_pad($this['username'], UsersTable::MAX_USER_CHARS, '0', STR_PAD_LEFT);
        } else {
            return $this['username'];
        }
    }
}
