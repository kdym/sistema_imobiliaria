<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CompanyData Entity
 *
 * @property int $id
 * @property string $nome
 * @property string $razao_social
 * @property string $endereco
 * @property string $numero
 * @property string $complemento
 * @property string $bairro
 * @property string $cidade
 * @property string $uf
 * @property string $cep
 * @property string $cnpj
 * @property string $creci
 * @property string $abadi
 * @property string $telefone_1
 * @property string $telefone_2
 * @property string $telefone_3
 * @property string $email
 * @property string $latitude
 * @property string $longitude
 */
class CompanyData extends Entity
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
}
