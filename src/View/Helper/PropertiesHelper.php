<?php

namespace App\View\Helper;

use App\Model\Table\PropertiesFeesTable;
use App\Model\Table\PropertiesTable;
use Cake\ORM\TableRegistry;
use Cake\View\Helper;
use Cake\View\Helper\UrlHelper;
use Cake\View\View;

/**
 * Properties helper
 */
class PropertiesHelper extends Helper
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function getMainPhoto($property)
    {
        $propertiesPhotosTable = TableRegistry::get('PropertiesPhotos');

        $photo = $propertiesPhotosTable->find()
            ->where(['property_id' => $property['id']])
            ->order('ordem')
            ->first();

        if ($photo) {
            return sprintf('/file/properties/%s/%s', $property['id'], $photo['url']);
        } else {
            return '/img/no_photo.png';
        }
    }

    public function getMainAddress($property)
    {
        return implode(', ', array_filter([
            $property['endereco'],
            $property['numero'],
            $property['complemento'],
            $property['bairro'],
            $property['cidade'],
            $property['uf'],
        ]));
    }

    public function getStatus($property)
    {
        $contractsTable = TableRegistry::get('Contracts');

        $urlHelper = new UrlHelper(new View());

        $contract = $contractsTable->find()
            ->contain('Tenants.Users')
            ->where(['property_id' => $property['id']])
            ->where(['finalizado is null'])
            ->last();

        if ($contract) {
            return sprintf('<a href="%s"><span class="text-danger">Alugado por %s - %s</span></a>',
                $urlHelper->build(['controller' => 'contracts', 'action' => 'view', $contract['id']]),
                $contract['tenant']['user']['formatted_username'],
                $contract['tenant']['user']['nome']
            );
        } else {
            return '<span class="text-success">Disponível</span>';
        }
    }

    public function getType($property)
    {
        return PropertiesTable::$propertyTypes[$property['tipo']];
    }

    public function getValue($property)
    {
        return 'R$ ' . number_format($property['properties_prices'][0]['valor'], 2, ',', '.');
    }

    public function getAdministrativeFee($property)
    {
        if ($property['properties_fees'][0]['taxa_administrativa_tipo'] == GlobalCombosHelper::COMISSION_TYPE_PERCENTAGE) {
            return number_format($property['properties_fees'][0]['taxa_administrativa'], 2, ',', '.') . '%';
        } else {
            return 'R$ ' . number_format($property['properties_fees'][0]['taxa_administrativa'], 2, ',', '.');
        }
    }

    public function getAdministrativeFeeIncidence($property)
    {
        return PropertiesFeesTable::$incidences[$property['properties_fees'][0]['taxa_administrativa_incidencia']];
    }

    public function get13thAdministrativeFee($property)
    {
        $value = $property['properties_fees'][0]['parcelas_13_taxa_administrativa'];

        if ($value == 1) {
            return '1 Parcela';
        } else {
            return $value . ' Parcelas';
        }
    }
}
