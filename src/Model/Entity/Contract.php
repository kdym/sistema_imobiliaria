<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Contract Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenTime $created
 * @property int $tipo_garantia
 * @property \Cake\I18n\Date $data_inicio
 * @property \Cake\I18n\Date $data_fim
 * @property int $tenant_id
 * @property int $property_id
 *
 * @property \App\Model\Entity\Tenant $tenant
 * @property \App\Model\Entity\Property $property
 * @property \App\Model\Entity\ContractsValue[] $contracts_values
 */
class Contract extends Entity
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
