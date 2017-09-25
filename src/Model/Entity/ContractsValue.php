<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ContractsValue Entity
 *
 * @property int $id
 * @property \Cake\I18n\Date $start_date
 * @property int $finalidade
 * @property string $finalidade_nao_residencial
 * @property int $vencimento_boletos
 * @property float $taxa_contratual
 * @property float $desconto
 * @property float $multa
 * @property bool $taxa_expediente
 * @property bool $cpmf
 * @property bool $taxa_correio
 * @property int $contract_id
 *
 * @property \App\Model\Entity\Contract $contract
 */
class ContractsValue extends Entity
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
