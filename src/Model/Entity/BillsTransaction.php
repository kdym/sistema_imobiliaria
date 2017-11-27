<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BillsTransaction Entity
 *
 * @property int $id
 * @property int $categoria
 * @property \Cake\I18n\Date $data_pago
 * @property \Cake\I18n\Date $data_vencimento
 * @property int $reference_id
 * @property float $valor
 * @property bool $ausente
 * @property \Cake\I18n\Date $debitada
 * @property float $diferenca
 *
 * @property \App\Model\Entity\Reference $reference
 */
class BillsTransaction extends Entity
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
