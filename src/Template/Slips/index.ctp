<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $bs
 */

use App\Model\Custom\Slip;
use App\Model\Table\PaidSlipsTable;
use App\Policy\SlipsCustomsValuesPolicy;
use App\Policy\SlipsPolicy;

echo $this->Html->css('contracts.min', ['block' => true]);

echo $this->Html->script('slips.min', ['block' => true]);
?>

<section class="content-header">
    <h1>
        <?php echo $this->Html->link('<i class="fa fa-arrow-left"></i>', ['controller' => "contracts", 'action' => 'view', $contract['id']], ['escape' => false]) ?>
        Boletos
        <small><?php echo $contract['property']['full_address'] ?></small>
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
                        <h1>Início</h1>

                        <h2><?php echo $contract['data_inicio'] ?></h2>
                    </div>
                </div>

                <div class="item">
                    <div class="icon">
                        <i class="fa fa-calendar"></i>
                    </div>

                    <div class="value">
                        <h1>Isenção</h1>

                        <h2><?php echo __('{0, plural, =0{Isento} =1{1 mês} other{# meses}}', [$contract['isencao']]) ?></h2>

                        <h3>
                            <?php $exemption = $this->Contracts->getExemptionRemaining($contract); ?>

                            <div class="progress small-progress" title="<?php echo $exemption['text'] ?>"
                                 data-toggle="tooltip">
                                <div class="progress-bar" style="width: <?php echo $exemption['percent'] ?>%"></div>
                            </div>
                        </h3>
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

    <div class="box">
        <div class="box-body">
            <?php echo $this->Form->create(null, ['type' => 'get']) ?>

            <label>Período</label>

            <div class="row">
                <div class="col-md-9 col-sm-6">
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('start_date', ['label' => false, 'class' => 'date-picker', 'value' => $this->request->getQuery('start_date')]) ?>
                        </div>
                        <div class="col-md-6">
                            <?php echo $this->Form->control('end_date', ['label' => false, 'class' => 'date-picker', 'value' => $this->request->getQuery('end_date')]) ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <?php echo $this->Form->button('<i class="fa fa-search"></i> Buscar', ['class' => 'btn btn-primary btn-block']) ?>
                </div>
            </div>

            <?php echo $this->Form->end() ?>
        </div>
    </div>

    <?php if (!empty($slips)) { ?>
        <div class="actions-bar">
            <?php echo $this->Slips->getAllReportButton($startDate->format('d/m/Y'), $endDate->format('d/m/Y'), $companyData, $contract) ?>
            <?php echo $this->Html->link('<i class="fa fa-usd"></i> Pagar Muitos', '', ['escape' => false, 'class' => 'btn btn-app', 'id' => 'pay-multiple-button']) ?>
        </div>
    <?php } ?>

    <ul class="circles-legend">
        <li><i class="fa fa-circle-o text-primary"></i> Normal</li>
        <li><i class="fa fa-circle-o text-success"></i> Pago</li>
        <li><i class="fa fa-circle-o text-danger"></i> Atrasado</li>
    </ul>

    <div class="box">
        <div class="box-body">
            <?php if (empty($contract['data_posse'])) { ?>
                <div class="alert alert-warning">
                    Data de Posse ainda não definida
                </div>
            <?php } else { ?>
                <?php if (!empty($slips)) { ?>
                    <div id="slips-info">
                        <?php /* @var Slip $s */ ?>
                        <?php foreach ($slips as $s) { ?>
                            <div class="slip">
                                <div class="row equal-height-row">
                                    <div class="col-md-3">
                                        <div class="slip-header <?php echo $this->Slips->getSlipClass($s) ?>">
                                            <div class="slip-header-container">
                                                <h1><?php echo $s->getSalary()->format('d/m/Y') ?></h1>

                                                <?php if ($s->getStatus() == Slip::PAID) { ?>
                                                    <small>Pago
                                                        em <?php echo $s->getPaidDate()->format('d/m/Y') ?></small>
                                                <?php } ?>

                                                <div class="actions">
                                                    <?php if (SlipsPolicy::isAuthorized('contractBills', $loggedUser, $s)) { ?>
                                                        <?php echo $this->Html->link('<i class="fa fa-plus fa-fw"></i>', ['action' => 'contract_bills', $contract['id']], ['escape' => false, 'class' => 'btn btn-default', 'title' => 'Adicionar Valores', 'data-toggle' => 'tooltip']) ?>
                                                    <?php } ?>

                                                    <?php if (SlipsPolicy::isAuthorized('pay', $loggedUser, $s)) { ?>
                                                        <a
                                                                href=""
                                                                class="btn btn-default slip-pay-button"
                                                                data-slip='<?php echo $s->toJSON() ?>'
                                                                title="Pagar Boleto"
                                                                data-toggle="tooltip">
                                                            <i class="fa fa-usd fa-fw"></i>
                                                        </a>
                                                    <?php } ?>

                                                    <?php if (SlipsPolicy::isAuthorized('unPay', $loggedUser, $s)) { ?>
                                                        <a
                                                                href=""
                                                                class="btn btn-default slip-unpay-button"
                                                                data-slip='<?php echo $s->toJSON() ?>'
                                                                title="Desfazer Pagamento"
                                                                data-toggle="tooltip">
                                                            <i class="fa fa-ban fa-fw"></i>
                                                        </a>
                                                    <?php } ?>

                                                    <?php if ($s->getStatus() <> Slip::PAID) { ?>
                                                        <?php echo $this->Slips->getReportButton($s->getSalary()->format('d/m/Y'), $companyData, $contract) ?>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-9">
                                        <div class="slip-body">
                                            <table class="table table-hover">
                                                <tbody>
                                                <?php $sum = 0; ?>
                                                <?php foreach ($s->getValues() as $v) { ?>
                                                    <?php $sum += $v->getValue(); ?>

                                                    <tr>
                                                        <td><?php echo $v->getName() ?></td>
                                                        <td class="to-right"><?php echo $this->Slips->formatCurrency($v->getValue()) ?></td>
                                                    </tr>
                                                <?php } ?>
                                                <tr>
                                                    <th>Total</th>
                                                    <th class="to-right"><?php echo $this->Slips->formatCurrency($sum) ?></th>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } else { ?>
                    <div class="alert alert-info">
                        Nenhum boleto encontrado para o período especificado
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</section>

<div class="modal fade" tabindex="-1" role="dialog" id="pay-slip-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Pagar Boleto</h4>
            </div>

            <?php echo $this->Form->create(null, ['url' => ['action' => 'pay_slip']]) ?>

            <?php echo $this->Form->control('pay_slip_selected_date', ['type' => 'hidden', 'value' => date('Y-m-d')]) ?>
            <?php echo $this->Form->control('pay_slip_hidden', ['type' => 'hidden']) ?>

            <div class="modal-body">
                <h3>Boleto com vencimento em <span id="pay-slip-salary"></span></h3>

                <p>Informe a Data de Pagamento</p>

                <div id="pay-slip-calendar"></div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Salvar</button>
            </div>

            <?php echo $this->Form->end() ?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="pay-multiple-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Pagar Muitos Boletos</h4>
            </div>

            <?php echo $this->Form->create(null, ['url' => ['action' => 'pay_multiple'], 'id' => 'pay-multiple-form']) ?>

            <?php echo $this->Form->control('pay_multiple_contract', ['type' => 'hidden', 'value' => $contract['id']]) ?>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="radio">
                            <label>
                                <input type="radio" checked="checked" id="pay-multiple-choice-until"
                                       name="pay_multiple_choice"
                                       value="<?php echo PaidSlipsTable::MULTIPLE_UNTIL ?>"/>
                                <?php echo PaidSlipsTable::$multipleOptions[PaidSlipsTable::MULTIPLE_UNTIL] ?>
                            </label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <?php echo $this->Form->control('multiple_until_date', ['label' => false, 'class' => 'date-picker']) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="radio">
                            <label>
                                <input type="radio" name="pay_multiple_choice" id="pay-multiple-choice-period"
                                       value="<?php echo PaidSlipsTable::MULTIPLE_PERIOD ?>"/>
                                <?php echo PaidSlipsTable::$multipleOptions[PaidSlipsTable::MULTIPLE_PERIOD] ?>
                            </label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <?php echo $this->Form->control('multiple_start_date', ['label' => false, 'class' => 'date-picker', 'data-accept' => PaidSlipsTable::MULTIPLE_PERIOD]) ?>
                    </div>

                    <div class="col-md-4">
                        <?php echo $this->Form->control('multiple_end_date', ['label' => false, 'class' => 'date-picker', 'data-accept' => PaidSlipsTable::MULTIPLE_PERIOD]) ?>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Salvar</button>
            </div>

            <?php echo $this->Form->end() ?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->