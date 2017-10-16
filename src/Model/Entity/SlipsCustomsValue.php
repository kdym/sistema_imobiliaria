<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SlipsCustomsValue Entity
 *
 * @property int $id
 * @property int $tipo
 * @property int $mes
 * @property int $ano
 * @property string $descricao
 * @property float $valor
 * @property bool $deleted
 * @property int $contract_id
 *
 * @property \App\Model\Entity\Contract $contract
 */
class SlipsCustomsValue extends Entity
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
