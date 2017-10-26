<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */

use App\Model\Table\ContractsTable;
use App\Model\Table\SlipsRecursiveTable;

echo $this->Html->script('slips.min', ['block' => true]);
?>

<section class="content-header">
    <h1>
        <?php echo $this->Html->link('<i class="fa fa-arrow-left"></i>', $referrer, ['escape' => false]) ?>
        Editar Boleto
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

    <div class="box">
        <div class="box-body" id="fees-container">
            <?php foreach ($slipValues->getValues() as $v) { ?>
                <?php
                $readOnly = true;
                $canDelete = false;

                if ($v->getType() == ContractsTable::CUSTOM_FEE) {
                    $canDelete = true;
                }

                if ($v->getType() == ContractsTable::DISCOUNT || $v->getType() == ContractsTable::FINE) {
                    continue;
                }

                echo $this->Form->control('type.', ['type' => 'hidden', 'value' => $v->getType()]);
                echo $this->Form->control('custom_id.', ['type' => 'hidden', 'value' => $v->getCustomId()]);
                ?>

                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php echo $this->Form->control('name.', ['label' => false, 'placeholder' => 'Descrição', 'value' => $v->getName(), 'readonly' => $readOnly, 'data-rule-required' => true]) ?>
                    </div>

                    <div class="col-md-3 col-sm-3 col-xs-7">
                        <?php echo $this->Form->control('value.', ['label' => false, 'placeholder' => 'Valor', 'value' => $this->SlipsCustomsValues->formatCurrency($v->getValue()), 'class' => 'mask-money-negative', 'data-rule-required' => true]) ?>
                    </div>

                    <div class="col-md-2 col-sm-2 col-xs-4 to-center">
                        <div class="actions-bar">
                            <i class="fa fa-refresh"></i> <?php echo $v->getRecursion()->toString() ?>
                        </div>
                    </div>

                    <div class="col-md-1 col-sm-1 col-xs-1">
                        <?php if ($canDelete) { ?>
                            <?php echo $this->Html->link('<i class="fa fa-trash"></i>', '', ['escape' => false, 'class' => 'btn btn-danger btn-block btn-sm delete-custom-button', 'data-custom-id' => $v->getCustomId()]) ?>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="actions-bar">
        <?php echo $this->Form->button('<i class="fa fa-check"></i> Salvar') ?>
    </div>

    <?php echo $this->Form->end() ?>

    <?php echo $this->Form->create(null, ['url' => ['action' => 'add_recursive_fee', $contract['id']], 'id' => 'recursive-fee-form']) ?>

    <?php echo $this->Form->control('slip_date', ['type' => 'hidden', 'value' => $slipDate->format('Y-m-d')]) ?>

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Nova Taxa</h3>
        </div>

        <div class="box-body">
            <div class="row">
                <div class="col-md-8">
                    <?php echo $this->Form->control('name', ['label' => 'Descrição']) ?>
                </div>

                <div class="col-md-4">
                    <?php echo $this->Form->control('value', ['label' => 'Valor', 'class' => 'mask-money-negative']) ?>
                </div>
            </div>

            <label>Recursividade</label>

            <div class="radio">
                <label>
                    <input type="radio" name="recursive" checked="checked" id="recursive-all-option"
                           value="<?php echo SlipsRecursiveTable::RECURSION_NONE ?>"/>
                    <?php echo SlipsRecursiveTable::$recursiveOptions[SlipsRecursiveTable::RECURSION_NONE] ?>
                </label>
            </div>

            <div class="radio">
                <label>
                    <input type="radio" name="recursive" id="recursive-all-option"
                           value="<?php echo SlipsRecursiveTable::RECURSION_ALL ?>"/>
                    <?php echo SlipsRecursiveTable::$recursiveOptions[SlipsRecursiveTable::RECURSION_ALL] ?>
                </label>
            </div>

            <div class="row">
                <div class="col-md-2">
                    <div class="radio">
                        <label>
                            <input type="radio" name="recursive" id="recursive-start-at-option"
                                   value="<?php echo SlipsRecursiveTable::RECURSION_START_AT ?>"/>
                            <?php echo SlipsRecursiveTable::$recursiveOptions[SlipsRecursiveTable::RECURSION_START_AT] ?>
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
                                   value="<?php echo SlipsRecursiveTable::RECURSION_PERIOD ?>"/>
                            <?php echo SlipsRecursiveTable::$recursiveOptions[SlipsRecursiveTable::RECURSION_PERIOD] ?>
                        </label>
                    </div>
                </div>

                <div class="col-md-4">
                    <?php echo $this->Form->control('period_input', ['label' => false, 'readonly' => true, 'class' => 'recursive-inputs date-range-picker']) ?>
                </div>
            </div>
        </div>
    </div>

    <?php echo $this->Form->button('<i class="fa fa-plus"></i> Adicionar Taxa') ?>

    <?php echo $this->Form->end() ?>
</section>

<div class="modal fade" tabindex="-1" role="dialog" id="delete-custom-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Excluir</h4>
            </div>

            <?php echo $this->Form->create(null, ['url' => ['action' => 'delete_custom']]) ?>

            <?php echo $this->Form->control('slip_date', ['type' => 'hidden', 'value' => $slipDate->format('Y-m-d')]) ?>
            <?php echo $this->Form->control('custom_id', ['type' => 'hidden', 'id' => 'delete-custom-hidden-id']) ?>
            <?php echo $this->Form->control('contract_id', ['type' => 'hidden', 'value' => $contract['id']]) ?>

            <div class="modal-body">
                <div class="big-radios">
                    <?php echo $this->Form->control('delete_option', ['options' => SlipsRecursiveTable::$deleteOptions, 'default' => SlipsRecursiveTable::DELETE_SINGLE, 'type' => 'radio', 'label' => false]) ?>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Excluir</button>
            </div>

            <?php echo $this->Form->end() ?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->