<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Recursive Entity
 *
 * @property int $id
 * @property string $dia
 * @property string $mes
 * @property string $ano
 * @property \Cake\I18n\Date $start_date
 * @property \Cake\I18n\Date $end_date
 *
 * @property \App\Model\Entity\SlipsCustomsValue[] $slips_customs_values
 */
class Recursive extends Entity
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
