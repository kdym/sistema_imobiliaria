<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CustomBill Entity
 *
 * @property int $id
 * @property int $categoria
 * @property string $descricao
 * @property int $pagante
 * @property int $recebedor
 * @property string $repeat_year
 * @property string $repeat_month
 * @property string $repeat_day
 * @property \Cake\I18n\Date $data_inicio
 * @property \Cake\I18n\Date $data_fim
 * @property float $valor
 * @property int $reference_id
 *
 * @property \App\Model\Entity\Reference $reference
 */
class CustomBill extends Entity
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
