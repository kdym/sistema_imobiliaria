<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $ls
 */

use App\Model\Table\PropertiesCompositionsTable;

$editLink = ['action' => 'form', $property['id']];

?>
<section class="content-header">
    <h1>Imóveis</h1>
</section>

<section class="content">
    <div class="masonry-list-50">
        <div class="box masonry-sizer-50">
            <div class="box-body">
                <div class="box-tools pull-right">
                    <?php echo $this->Html->link('<i class="fa fa-pencil"></i>', $editLink, ['escape' => false]) ?>
                </div>

                <div class="icon-view-list">
                    <div class="item">
                        <div class="icon">
                            <i class="fa fa-map-marker"></i>
                        </div>

                        <div class="value">
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
                    <?php if (!empty($property['properties_compositions'][0]['quartos'])) { ?>
                        <div class="item">
                            <div class="icon">
                                <i class="fa fa-bed"></i>
                            </div>

                            <div class="value">
                                <h1>Quartos</h1>

                                <h2><?php echo $property['properties_compositions'][0]['quartos'] ?></h2>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if (!empty($property['properties_compositions'][0]['suites'])) { ?>
                        <div class="item">
                            <div class="icon">
                                <i class="fa fa-bed"></i>
                            </div>

                            <div class="value">
                                <h1>Suítes</h1>

                                <h2><?php echo $property['properties_compositions'][0]['suites'] ?></h2>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if (!empty($property['properties_compositions'][0]['garagens'])) { ?>
                        <div class="item">
                            <div class="icon">
                                <i class="fa fa-car"></i>
                            </div>

                            <div class="value">
                                <h1>Garagens</h1>

                                <h2><?php echo $property['properties_compositions'][0]['garagens'] ?></h2>
                            </div>
                        </div>
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
    </div>
</section>