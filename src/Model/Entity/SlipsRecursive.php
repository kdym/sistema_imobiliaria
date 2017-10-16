<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SlipsRecursive Entity
 *
 * @property int $id
 * @property \Cake\I18n\Date $start_date
 * @property \Cake\I18n\Date $end_date
 * @property bool $deleted
 * @property int $slip_custom_id
 * @property string $tipo
 * @property int $contract_id
 * @property float $valor
 *
 * @property \App\Model\Entity\SlipsCustomValue $slips_custom_value
 * @property \App\Model\Entity\Contract $contract
 */
class SlipsRecursive extends Entity
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
