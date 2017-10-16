<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */

use App\Model\Table\ContractsTable;
use App\Model\Table\SlipsCustomsValuesTable;

echo $this->Html->script('slips-customs-values.min', ['block' => true]);
?>

<section class="content-header">
    <h1>Editar Boleto
        <small><?php echo $slipDate->format('d/m/Y') ?></small>
    </h1>
</section>

<section class="content">
    <div class="box">
        <div class="box-body">
            <div class="icon-view-list">
                <div class="item">
                    <div class="icon">
                        <i class="fa fa-calendar"></i>
                    </div>

                    <div class="value">
                        <h1>Período</h1>

                        <h2><?php echo sprintf('%s a %s', $contract['data_inicio'], $contract['data_fim']) ?></h2>

                        <h3><?php echo $this->Contracts->getMonthsInPeriod($contract) ?></h3>
                    </div>
                </div>

                <div class="item">
                    <div class="icon">
                        <i class="fa fa-money"></i>
                    </div>

                    <div class="value">
                        <h1>Valor do Contrato</h1>

                        <h2><?php echo $this->Contracts->getContractValue($contract) ?></h2>
                    </div>
                </div>

                <div class="item">
                    <div class="icon">
                        <i class="fa fa-percent"></i>
                    </div>

                    <div class="value">
                        <h1><?php echo $this->Contracts->getDiscountOrFineTitle($contract) ?></h1>

                        <h2><?php echo $this->Contracts->getDiscountOrFine($contract) ?></h2>
                    </div>
                </div>

                <div class="item">
                    <div class="icon">
                        <i class="fa fa-calendar"></i>
                    </div>

                    <div class="value">
                        <h1>Vencimento 1º Boleto</h1>

                        <h2><?php echo $contract['primeiro_vencimento'] ?></h2>
                    </div>
                </div>

                <div class="item">
                    <div class="icon">
                        <i class="fa fa-calendar"></i>
                    </div>

                    <div class="value">
                        <h1>Dia Vencimento</h1>

                        <h2><?php echo $contract['contracts_values'][0]['vencimento_boleto'] ?></h2>
                    </div>
                </div>

                <div class="item">
                    <div class="icon">
                        <i class="fa fa-calendar"></i>
                    </div>

                    <div class="value">
                        <h1>Data de Posse</h1>

                        <h2><?php echo (!empty($contract['data_posse'])) ? $contract['data_posse'] : 'Não definido' ?></h2>
                    </div>
                </div>

                <div class="item">
                    <div class="icon">
                        <i class="fa fa-calendar"></i>
                    </div>

                    <div class="value">
                        <h1>Data de Devolução</h1>

                        <h2><?php echo (!empty($contract['data_devolucao'])) ? $contract['data_devolucao'] : 'Não definido' ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php echo $this->Form->create(null, ['id' => 'add-fee-form']) ?>

    <div class="actions-bar to-right">
        <button type="button" id="new-fee-button" class="btn btn-primary"><i class="fa fa-plus"></i> Nova Taxa</button>
    </div>

    <div class="box">
        <div class="box-body" id="fees-container">
            <div class="actions-bar">
                <div class="row">
                    <div class="col-md-7 col-sm-5 col-xs-12">Descrição</div>
                    <div class="col-md-3 col-sm-5 col-xs-10">Valor</div>
                    <div class="col-md-2 col-sm-2 col-xs-2 to-center">Excluir</div>
                </div>
            </div>

            <?php foreach ($slipValues as $v) { ?>
                <?php if (
                    $v['type'] <> ContractsTable::DISCOUNT &&
                    $v['type'] <> ContractsTable::FINE
                ) { ?>
                    <?php
                    $readOnly = true;
                    $canDelete = false;

                    if ($v['type'] == SlipsCustomsValuesTable::CUSTOM) {
                        $readOnly = false;
                        $canDelete = true;
                    }
                    ?>

                    <div class="row">
                        <div class="col-md-7 col-sm-5 col-xs-12">
                            <?php echo $this->Form->control('name.', ['label' => false, 'placeholder' => 'Descrição', 'value' => $v['name'], 'readonly' => $readOnly, 'data-rule-required' => true]) ?>

                            <?php echo $this->Form->control('type.', ['type' => 'hidden', 'value' => $v['type']]) ?>
                            <?php echo $this->Form->control('custom_id.', ['type' => 'hidden', 'value' => $v['custom_id']]) ?>
                        </div>

                        <div class="col-md-3 col-sm-5 col-xs-10">
                            <?php echo $this->Form->control('value.', ['label' => false, 'placeholder' => 'Valor', 'value' => $this->SlipsCustomsValues->formatCurrency($v['value']), 'class' => 'mask-money-negative', 'data-rule-required' => true]) ?>
                        </div>

                        <div class="col-md-2 col-sm-2 col-xs-2 to-center">
                            <?php if ($canDelete) { ?>
                                <input type="checkbox" class="single-checkbox"
                                       name="delete_fee[<?php echo $v['custom_id'] ?>]"/>
                            <?php } else { ?>
                                <i class="fa fa-ban single-checkbox" data-toggle="tooltip"
                                   title="Não é possível excluir taxas geradas pelo Sistema"></i>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>

    <div class="actions-bar">
        <?php echo $this->Form->button('<i class="fa fa-check"></i> Salvar') ?>
    </div>

    <?php echo $this->Form->end() ?>

    <?php echo $this->Form->create(null, ['url' => ['action' => 'add_recursive_fee', $contract['id']], 'id' => 'recursive-fee-form']) ?>

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Taxas Recorrentes</h3>
        </div>

        <div class="box-body">
            <div class="row">
                <div class="col-md-8">
                    <?php echo $this->Form->control('name', ['label' => 'Descrição']) ?>
                    <?php echo $this->Form->control('slip_date', ['type' => 'hidden', 'value' => $slipDate->format('Y-m-d')]) ?>
                </div>

                <div class="col-md-4">
                    <?php echo $this->Form->control('value', ['label' => 'Valor', 'class' => 'mask-money-negative']) ?>
                </div>
            </div>

            <label>Recursividade</label>

            <div class="radio">
                <label>
                    <input type="radio" name="recursive" checked="checked" id="recursive-all-option"
                           value="<?php echo SlipsCustomsValuesTable::RECURSIVE_ALL ?>"/>
                    <?php echo SlipsCustomsValuesTable::$recursiveOptions[SlipsCustomsValuesTable::RECURSIVE_ALL] ?>
                </label>
            </div>

            <div class="row">
                <div class="col-md-2">
                    <div class="radio">
                        <label>
                            <input type="radio" name="recursive" id="recursive-start-at-option"
                                   value="<?php echo SlipsCustomsValuesTable::RECURSIVE_START_AT ?>"/>
                            <?php echo SlipsCustomsValuesTable::$recursiveOptions[SlipsCustomsValuesTable::RECURSIVE_START_AT] ?>
                        </label>
                    </div>
                </div>

                <div class="col-md-4">
                    <?php echo $this->Form->control('start_at_input', ['label' => false, 'readonly' => true, 'class' => 'recursive-inputs date-picker']) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2">
                    <div class="radio">
                        <label>
                            <input type="radio" name="recursive" id="recursive-period-option"
                                   value="<?php echo SlipsCustomsValuesTable::RECURSIVE_PERIOD ?>"/>
                            <?php echo SlipsCustomsValuesTable::$recursiveOptions[SlipsCustomsValuesTable::RECURSIVE_PERIOD] ?>
                        </label>
                    </div>
                </div>

                <div class="col-md-4">
                    <?php echo $this->Form->control('period_input', ['label' => false, 'readonly' => true, 'class' => 'recursive-inputs date-range-picker']) ?>
                </div>
            </div>
        </div>
    </div>

    <?php echo $this->Form->button('<i class="fa fa-plus"></i> Adicionar Taxa Recorrente') ?>

    <?php echo $this->Form->end() ?>
</section>

<script type="text/html" id="new-fee-template">
    <div class="row">
        <div class="col-md-7 col-sm-5 col-xs-12">
            <?php echo $this->Form->control('name.', ['label' => false, 'placeholder' => 'Descrição', 'data-rule-required' => true]) ?>

            <?php echo $this->Form->control('type.', ['type' => 'hidden', 'value' => SlipsCustomsValuesTable::CUSTOM]) ?>
            <?php echo $this->Form->control('custom_id.', ['type' => 'hidden', 'value' => null]) ?>
        </div>

        <div class="col-md-3 col-sm-5 col-xs-10">
            <?php echo $this->Form->control('value.', ['label' => false, 'placeholder' => 'Valor', 'class' => 'mask-money-negative', 'data-rule-required' => true]) ?>
        </div>

        <div class="col-md-2 col-sm-2 col-xs-2 to-center"></div>
    </div>
</script>