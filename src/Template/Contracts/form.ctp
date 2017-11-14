<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $bs
 */

use App\Model\Table\ContractsTable;
use App\Model\Table\ContractsValuesTable;

echo $this->Html->script('contracts.min', ['block' => true]);

?>
<section class="content-header">
    <h1>Contratos</h1>
</section>

<section class="content">
    <?php echo $this->Form->create($contract) ?>

    <?php if (!$id) { ?>
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <?php echo $this->Form->control('tenant', ['label' => 'Locatário', 'placeholder' => 'Buscar...']) ?>

                        <?php echo $this->Form->control('tenant_id', ['type' => 'hidden']) ?>
                    </div>

                    <div class="col-md-6">
                        <?php echo $this->Form->control('property', ['label' => 'Imóvel', 'placeholder' => 'Buscar...']) ?>

                        <?php echo $this->Form->control('property_id', ['type' => 'hidden']) ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php if (!$id) { ?>
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <?php echo $this->Form->control('data_inicio', ['label' => 'Início', 'class' => 'date-picker', 'type' => 'text']) ?>
                    </div>

                    <div class="col-md-4">
                        <?php echo $this->Form->control('isencao', ['label' => 'Isenção (meses)', 'maxlength' => 2, 'class' => 'number-only', 'type' => 'text']) ?>
                    </div>

                    <div class="col-md-4">
                        <?php echo $this->Form->control('primeiro_vencimento', ['label' => 'Vencimento 1º Boleto', 'type' => 'text', 'class' => 'date-picker']) ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <?php echo $this->Form->control('isencao', ['label' => 'Isenção (meses)', 'maxlength' => 2, 'class' => 'number-only', 'type' => 'text']) ?>
                    </div>

                    <div class="col-md-4">
                        <?php echo $this->Form->control('primeiro_vencimento', ['label' => 'Vencimento 1º Boleto', 'type' => 'text', 'class' => 'date-picker']) ?>
                    </div>

                    <div class="col-md-4">
                        <?php echo $this->Form->control('dia_vencimento', ['class' => 'number-only']) ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php if ($id) { ?>
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <?php echo $this->Form->control('data_posse', ['label' => 'Data de Posse', 'type' => 'text', 'class' => 'date-picker']) ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php if (!$id) { ?>
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <?php echo $this->Form->control('finalidade', ['options' => ContractsTable::$finalities, 'empty' => true]) ?>
                    </div>
                </div>

                <div id="non-residential-div" data-accept="<?php echo ContractsTable::FINALITY_NON_RESIDENTIAL ?>">
                    <?php echo $this->Form->control('finalidade_nao_residencial', ['label' => 'Especificação']) ?>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <?php echo $this->Form->control('tipo_garantia', ['label' => 'Garantia', 'options' => ContractsTable::$warranties, 'empty' => true]) ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <?php echo $this->Form->control('taxa_contratual', ['class' => 'mask-money']) ?>
                </div>
            </div>

            <label>Desconto/Multa (%)</label>

            <div class="row">
                <div class="col-md-6">
                    <?php echo $this->Form->control('discount_fine_choice', ['label' => false, 'options' => ContractsTable::$discountOrFine, 'empty' => true]) ?>
                </div>

                <div class="col-md-6">
                    <?php echo $this->Form->control('discount_fine', ['label' => false, 'class' => 'mask-number']) ?>
                </div>
            </div>

            <?php foreach (ContractsValuesTable::$fees as $key => $f) { ?>
                <?php echo $this->Form->control($key, ['label' => $f, 'type' => 'checkbox']) ?>
            <?php } ?>
        </div>
    </div>

    <?php echo $this->Form->button('<i class="fa fa-check"></i> Salvar') ?>

    <?php echo $this->Form->end() ?>
</section>

<script type="text/html" id="tenants-search-template">
    <p>
        ${name}
        <small>${username}</small>
    </p>
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