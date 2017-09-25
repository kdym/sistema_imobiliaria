<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Property Entity
 *
 * @property int $id
 * @property string $endereco
 * @property string $numero
 * @property string $complemento
 * @property string $bairro
 * @property string $cidade
 * @property string $uf
 * @property string $cep
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $deleted
 * @property string $latitude
 * @property string $longitude
 * @property string $descricao
 * @property int $tipo
 * @property bool $draft
 * @property string $codigo_saae
 * @property int $locator_id
 *
 * @property \App\Model\Entity\Locator $locator
 * @property \App\Model\Entity\PropertiesComposition[] $properties_compositions
 * @property \App\Model\Entity\PropertiesFee[] $properties_fees
 * @property \App\Model\Entity\PropertiesPrice[] $properties_prices
 */
class Property extends Entity
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
    protected $_virtual = [
        'full_address',
        'main_photo',
    ];

    protected function _getFullAddress()
    {
        return implode(', ', array_filter([
            $this['endereco'],
            $this['numero'],
            $this['complemento'],
            $this['bairro'],
            $this['cidade'],
            $this['uf'],
        ]));
    }

    protected function _getMainPhoto()
    {
        return '/img/no_photo.png';
    }
}
