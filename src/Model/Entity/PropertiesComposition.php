<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PropertiesComposition Entity
 *
 * @property int $id
 * @property int $quartos
 * @property int $suites
 * @property int $garagens
 * @property bool $condominio_fechado
 * @property bool $piscina
 * @property bool $salao_festas
 * @property bool $area_churrasqueira
 * @property \Cake\I18n\Date $start_date
 * @property int $property_id
 *
 * @property \App\Model\Entity\Property $property
 */
class PropertiesComposition extends Entity
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
