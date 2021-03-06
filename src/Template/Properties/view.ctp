<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $ls
 */

use App\Model\Table\PropertiesCompositionsTable;
use App\Model\Table\PropertiesTable;
use App\Policy\CommonBillsPolicy;
use App\Policy\LocatorsAssociationsPolicy;
use App\Policy\PropertiesPolicy;

echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js', ['block' => true]);

echo $this->Html->script("https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js", ['block' => true]);
echo $this->Html->css("https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.css", ['block' => true]);

echo $this->Html->script('properties.min', ['block' => true]);
echo $this->Html->css('properties.min', ['block' => true]);

$editLink = ['action' => 'form', $property['id']];

?>
<section class="content-header">
    <h1>Imóveis</h1>
</section>

<input type="hidden" id="property-hidden-id" value="<?php echo $property['id'] ?>"/>

<section class="content">
    <div class="masonry-list-50">
        <div class="box masonry-sizer-50">
            <div class="box-body">
                <div id="property-map" class="box-map" data-latitude="<?php echo $property['latitude'] ?>"
                     data-longitude="<?php echo $property['longitude'] ?>"></div>

                <div class="box-tools pull-right">
                    <?php echo $this->Html->link('<i class="fa fa-pencil"></i>', $editLink, ['escape' => false]) ?>
                </div>

                <div class="icon-view-list">
                    <div class="item">
                        <div class="icon">
                            <i class="fa fa-map-marker"></i>
                        </div>

                        <div class="value">
                            <h1><?php echo $property['formatted_code'] ?></h1>

                            <h2>
                                <?php echo implode(', ', array_filter([
                                    $property['endereco'],
                                    $property['numero'],
                                    $property['complemento'],
                                ])) ?>
                            </h2>

                            <h3>
                                <?php echo implode(', ', [
                                    $property['bairro'],
                                    $property['cidade'],
                                    $property['uf'],
                                ]) ?>
                            </h3>

                            <h4><?php echo $property['cep'] ?></h4>
                        </div>
                    </div>
                </div>

                <div class="icon-view-list">
                    <div class="item">
                        <div class="icon">
                            <i class="fa fa-home"></i>
                        </div>

                        <div class="value">
                            <h1>Tipo</h1>

                            <h2><?php echo $this->Properties->getType($property) ?></h2>

                            <h3><?php echo PropertiesTable::$propertyCategories[$property['properties_fees'][0]['imovel_tipo']] ?></h3>
                        </div>
                    </div>

                    <?php if (!empty($property['codigo_saae'])) { ?>
                        <div class="item">
                            <div class="icon">
                                <i class="fa fa-tint"></i>
                            </div>

                            <div class="value">
                                <h1>Código SAAE</h1>

                                <h2><?php echo $property['codigo_saae'] ?></h2>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="item">
                        <div class="icon">
                            <i class="fa fa-user"></i>
                        </div>

                        <div class="value">
                            <h1>Locador</h1>

                            <h2><?php echo $property['locator']['user']['nome'] ?></h2>

                            <h3><?php echo $property['locator']['user']['formatted_username'] ?></h3>
                        </div>
                    </div>

                    <div class="item">
                        <div class="icon">
                            <i class="fa fa-user"></i>
                        </div>

                        <div class="value">
                            <h1>Corretor</h1>

                            <h2><?php echo $property['user']['nome'] ?></h2>

                            <h3><?php echo $property['user']['formatted_username'] ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="box masonry-sizer-50">
            <div class="box-header with-border">
                <h3 class="box-title">Composição</h3>

                <div class="box-tools pull-right">
                    <?php echo $this->Html->link('<i class="fa fa-pencil"></i>', $editLink, ['escape' => false]) ?>
                </div>
            </div>

            <div class="box-body">
                <div class="icon-view-list">
                    <?php foreach (PropertiesCompositionsTable::$propertiesItems as $i) { ?>
                        <?php if (!empty($property['properties_compositions'][0][$i->getKey()])) { ?>
                            <div class="item">
                                <div class="icon">
                                    <i class="fa fa-<?php echo $i->getIcon() ?>"></i>
                                </div>

                                <div class="value">
                                    <h1><?php echo $i->getName() ?></h1>

                                    <h2><?php echo $property['properties_compositions'][0][$i->getKey()] ?></h2>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>

                <ul class="vertical-icon-list">
                    <?php foreach (PropertiesCompositionsTable::$compositions as $key => $c) { ?>
                        <?php if (!empty($property['properties_compositions'][0][$key])) { ?>
                            <li><i class="fa fa-check"></i> <?php echo $c ?></li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </div>
        </div>

        <div class="box masonry-sizer-50">
            <div class="box-header with-border">
                <h3 class="box-title">Taxas</h3>

                <div class="box-tools pull-right">
                    <?php echo $this->Html->link('<i class="fa fa-pencil"></i>', $editLink, ['escape' => false]) ?>
                </div>
            </div>

            <div class="box-body">
                <div class="icon-view-list">
                    <div class="item">
                        <div class="icon">
                            <i class="fa fa-money"></i>
                        </div>

                        <div class="value">
                            <h1>Valor do Imóvel</h1>

                            <h2><?php echo $this->Properties->getValue($property) ?></h2>
                        </div>
                    </div>

                    <div class="item">
                        <div class="icon">
                            <i class="fa fa-percent"></i>
                        </div>

                        <div class="value">
                            <h1>Taxa Administrativa</h1>

                            <h2><?php echo $this->Properties->getAdministrativeFee($property) ?></h2>

                            <h3><?php echo $this->Properties->getAdministrativeFeeIncidence($property) ?></h3>
                        </div>
                    </div>

                    <?php if (!empty($property['properties_fees'][0]['parcelas_13_taxa_administrativa'])) { ?>
                        <div class="item">
                            <div class="icon">
                                <i class="fa fa-percent"></i>
                            </div>

                            <div class="value">
                                <h1>13ª Taxa Administrativa</h1>

                                <h2><?php echo $this->Properties->get13thAdministrativeFee($property) ?></h2>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="box masonry-sizer-50">
            <div class="box-header with-border">
                <h3 class="box-title">Descrição</h3>

                <div class="box-tools pull-right">
                    <?php echo $this->Html->link('<i class="fa fa-pencil"></i>', $editLink, ['escape' => false]) ?>
                </div>
            </div>

            <div class="box-body">
                <div class="small-long-text">
                    <?php echo $property['descricao'] ?>
                </div>
            </div>
        </div>

        <div class="box masonry-sizer-50">
            <div class="box-header with-border">
                <h3 class="box-title">Locadores Associados</h3>

                <?php if (LocatorsAssociationsPolicy::isAuthorized('form', $loggedUser)) { ?>
                    <div class="box-tools pull-right">
                        <?php echo $this->Html->link('<i class="fa fa-pencil"></i>', ['controller' => 'locators_associations', 'action' => 'form', $property['id']], ['escape' => false]) ?>
                    </div>
                <?php } ?>
            </div>

            <div class="box-body">
                <canvas id="locators-associations-chart" class="graph-container"
                        data-dataset='<?php echo json_encode($locatorsAssociationsDataset['dataset']) ?>'
                        data-labels='<?php echo json_encode($locatorsAssociationsDataset['labels']) ?>'
                        data-colors='<?php echo json_encode($locatorsAssociationsDataset['colors']) ?>'></canvas>
            </div>
        </div>

        <div class="box masonry-sizer-100" id="common-bills-box">
            <div class="box-header with-border">
                <h3 class="box-title">Contas</h3>

                <div class="box-tools pull-right">
                    <?php echo $this->Html->link('<i class="fa fa-pencil"></i>', $editLink, ['escape' => false]) ?>
                </div>
            </div>

            <div class="box-body">
                <?php foreach (PropertiesTable::$propertiesBills as $key => $b) { ?>
                    <?php if (!empty($property['properties_fees'][0][$key])) { ?>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-2">
                                <h3>Contas Comuns</h3>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="icon-view-list">
                                    <div class="item">
                                        <div class="icon">
                                            <?php if (PropertiesPolicy::isAuthorized('billEntries', $loggedUser)) { ?>
                                                <a href="<?php echo $this->Url->build(['action' => 'bill_entries', $key]) ?>">
                                                    <i class="fa fa-<?php echo PropertiesTable::$propertiesBillsIcons[$key] ?>"></i>
                                                </a>
                                            <?php } else { ?>
                                                <i class="fa fa-<?php echo PropertiesTable::$propertiesBillsIcons[$key] ?>"></i>
                                            <?php } ?>
                                        </div>

                                        <div class="value">
                                            <h1>Vencimento</h1>

                                            <h2><?php echo $property['properties_fees'][0][$key] ?></h2>

                                            <h3><?php echo $b ?></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-10">
                                <?php if (CommonBillsPolicy::isAuthorized('add', $loggedUser)) { ?>
                                    <?php echo $this->Form->create() ?>

                                    <div class="row">
                                        <div class="col-md-9">
                                            <?php echo $this->Form->control('search_property_' . $key, ['label' => false, 'placeholder' => 'Adicionar Imóvel...', 'data-common-bill-type' => $key]) ?>
                                        </div>
                                    </div>

                                    <?php echo $this->Form->end() ?>
                                <?php } ?>

                                <?php if (!empty($commonBills[$key])) { ?>
                                    <div class="thumbs-list">
                                        <div class="row">
                                            <?php foreach ($commonBills[$key] as $b) { ?>
                                                <div class="col-md-3 col-sm-6">
                                                    <div class="item">
                                                        <div class="item-wrapper">
                                                            <figure>
                                                                <a href="<?php echo $this->Url->build(['controller' => 'properties', 'action' => 'view', $b['property']['id']]) ?>">
                                                                    <?php echo $this->Html->image($this->Properties->getMainPhoto($b['property'])) ?>
                                                                </a>
                                                            </figure>

                                                            <h1>
                                                                <?php echo $this->Properties->getMainAddress($b['property']) ?>
                                                                <small><?php echo $b['property']['formatted_code'] ?></small>
                                                            </h1>

                                                            <h2>
                                                                <?php echo $b['property']['locator']['user']['nome'] ?>
                                                                <small><?php echo $b['property']['locator']['user']['formatted_username'] ?></small>
                                                            </h2>

                                                            <h3><?php echo $this->Properties->getStatus($b['property']) ?></h3>
                                                        </div>

                                                        <nav class="actions">
                                                            <?php if (CommonBillsPolicy::isAuthorized('delete', $loggedUser)) { ?>
                                                                <?php echo $this->Html->link('<i class="fa fa-trash"></i>', ['controller' => 'common_bills', 'action' => 'delete', $b['id']], ['escape' => false, 'class' => 'btn btn-danger', 'confirm' => 'Tem certeza que deseja excluir?']) ?>
                                                            <?php } ?>
                                                        </nav>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>

        <div class="box masonry-sizer-100" id="photo-gallery-box">
            <div class="box-header with-border">
                <h3 class="box-title">Fotos</h3>
            </div>

            <div class="box-body">
                <div id="photo-gallery-view"></div>

                <div class="actions-bar">
                    <div class="row">
                        <div class="col-md-6">
                            <i class="fa fa-lightbulb-o"></i> Arraste as fotos para alterar a ordem de exibição das
                            imagens
                        </div>

                        <div class="col-md-6 to-right">
                            <button class="btn btn-danger" disabled="disabled" id="delete-photos"><i
                                        class="fa fa-trash"></i> Excluir
                                selecionados
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="box masonry-sizer-100">
            <div class="box-header with-border">
                <h3 class="box-title">Enviar Fotos</h3>
            </div>

            <div class="box-body">
                <div class="image-gallery" data-property="<?php echo $property['id'] ?>">
                    <div class='upload-form'>
                        <button id="gallery-add-button" class='btn btn-primary add-photos-buttton'><i
                                    class="glyphicon glyphicon-plus"></i> Adicionar fotos...
                        </button>
                        <button id="gallery-upload-button" disabled="disabled"
                                class='btn btn-success upload-photos-button'><i
                                    class="glyphicon glyphicon-upload"></i> Iniciar Upload
                        </button>
                        <button id="gallery-cancel-button" disabled="disabled"
                                class='btn btn-danger cancel-upload-button'><i
                                    class="glyphicon glyphicon-remove"></i> Cancelar
                        </button>
                    </div>

                    <div class='dropzone image-previews' id="images-preview">
                        <div class="images-preview-instructions">
                            <i class="fa fa-files-o"></i> Arraste os arquivos aqui para iniciar o upload
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/html" id="photo-gallery-template">
    <div class="photo-container" id="image_${id}">
        <input type="checkbox" class="gallery-checkbox" value="${id}"/>

        <img src="${photo}"/>
    </div>
</script>

<script type="text/html" id="properties-search-template">
    <div class="row">
        <div class="col-md-2">
            <img src="${photo}" class="img-responsive img-rounded"/>
        </div>

        <div class="col-md-10">
            <h1 class="search-h1">
                ${address}
                <small>${code}</small>
            </h1>

            <h2 class="search-h2">${locator}
                <small>${locator_username}</small>
            </h2>
        </div>
    </div>
</script>