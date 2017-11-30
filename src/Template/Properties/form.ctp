<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $ls
 */

use App\Model\Table\PropertiesCompositionsTable;
use App\Model\Table\PropertiesFeesTable;
use App\Model\Table\PropertiesTable;
use App\View\Helper\GlobalCombosHelper;

echo $this->Html->script('AdminLTE./plugins/ckeditor/ckeditor', ['block' => true]);

echo $this->Html->script('properties.min', ['block' => true]);
?>
<section class="content-header">
    <h1>Imóveis</h1>
</section>

<section class="content">
    <?php echo $this->Form->create($property) ?>

    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <?php echo $this->Form->control('cep', ['label' => 'CEP', 'class' => 'cep-mask']) ?>
                </div>
            </div>

            <?php echo $this->Form->control('endereco', ['label' => 'Endereço']) ?>

            <div class="row">
                <div class="col-md-6">
                    <?php echo $this->Form->control('numero', ['label' => 'Número']) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?php echo $this->Form->control('complemento') ?>
                </div>
            </div>

            <?php echo $this->Form->control('bairro') ?>
            <?php echo $this->Form->control('cidade') ?>

            <div class="row">
                <div class="col-md-6">
                    <?php echo $this->Form->control('uf', ['label' => 'UF', 'options' => GlobalCombosHelper::$brazilianStates, 'empty' => true]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?php echo $this->Form->control('codigo_saae', ['label' => 'Código SAAE']) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <div class="box-body">
                    <?php echo $this->Form->control('tipo', ['options' => PropertiesTable::$propertyTypes, 'empty' => true]) ?>

                    <div class="row">
                        <?php foreach (PropertiesCompositionsTable::$propertiesItems as $i) { ?>
                            <div class="col-md-4">
                                <?php echo $this->Form->control($i->getKey(), ['label' => $i->getName(), 'class' => 'number-only']) ?>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="row">
                        <?php foreach (PropertiesCompositionsTable::$compositions as $key => $c) { ?>
                            <div class="col-md-6">
                                <?php echo $this->Form->control($key, ['label' => $c, 'type' => 'checkbox']) ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('valor', ['label' => 'Valor do Aluguel', 'class' => 'mask-money']) ?>
                        </div>
                    </div>

                    <label>Taxa Administrativa</label>

                    <div class="row">
                        <div class="col-md-4">
                            <?php echo $this->Form->control('taxa_administrativa_incidencia', ['label' => false, 'options' => PropertiesFeesTable::$incidences, 'empty' => true]) ?>
                        </div>

                        <div class="col-md-4">
                            <?php echo $this->Form->control('taxa_administrativa_tipo', ['label' => false, 'options' => GlobalCombosHelper::$comissionTypes, 'empty' => true]) ?>
                        </div>

                        <div class="col-md-4">
                            <?php echo $this->Form->control('taxa_administrativa', ['label' => false, 'class' => 'mask-number']) ?>
                        </div>
                    </div>

                    <label>Parcelas da 13ª Taxa Administrativa</label>

                    <div class="row">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('parcelas_13_taxa_administrativa', ['label' => false, 'class' => 'number-only']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <?php echo $this->Form->control('locator_search', ['label' => 'Locador', 'placeholder' => 'Buscar...']) ?>

                    <?php echo $this->Form->control('locator_id', ['type' => 'hidden']) ?>
                </div>

                <div class="col-md-6">
                    <?php echo $this->Form->control('broker_search', ['label' => 'Corretor', 'placeholder' => 'Buscar...']) ?>

                    <?php echo $this->Form->control('broker', ['type' => 'hidden']) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="box">
        <div class="box-body">
            <?php echo $this->Form->control('descricao', ['label' => 'Descrição']) ?>
        </div>
    </div>

    <?php echo $this->Form->button('<i class="fa fa-check"></i> Salvar') ?>

    <?php echo $this->Form->end() ?>
</section>

<script type="text/html" id="locators-search-template">
    <p>
        ${name}
        <small>${username}</small>
    </p>
</script>

<script type="text/html" id="brokers-search-template">
    <p>
        ${name}
        <small>${username}</small>
    </p>
</script>