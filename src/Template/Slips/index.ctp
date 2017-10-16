<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $bs
 */

use App\Policy\SlipsCustomsValuesPolicy;
use App\Policy\SlipsPolicy;

echo $this->Html->css('contracts.min', ['block' => true]);
?>

<section class="content-header">
    <h1>Boletos
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

    <div class="box">
        <div class="box-body">
            <?php echo $this->Form->create() ?>

            <label>Período</label>

            <div class="row">
                <div class="col-md-9 col-sm-6">
                    <?php echo $this->Form->control('period', ['label' => false, 'class' => 'date-range-picker']) ?>
                </div>

                <div class="col-md-3 col-sm-6">
                    <?php echo $this->Form->button('<i class="fa fa-search"></i> Buscar', ['class' => 'btn btn-primary btn-block']) ?>
                </div>
            </div>

            <?php echo $this->Form->end() ?>
        </div>
    </div>

    <?php if (!empty($slips)) { ?>
        <div class="actions-bar to-right">
            <!--            --><?php echo $this->Slips->getAllReportButton($startDate->format('d/m/Y'), $endDate->format('d/m/Y'), $companyData, $contract) ?>
        </div>
    <?php } ?>

    <div class="box">
        <div class="box-body">
            <?php if (empty($contract['data_posse'])) { ?>
                <div class="alert alert-warning">
                    Data de Posse ainda não definida
                </div>
            <?php } else { ?>
                <?php if (!empty($slips)) { ?>
                    <div id="slips-info">
                        <?php foreach ($slips as $s) { ?>
                            <div class="slip">
                                <div class="row equal-height-row">
                                    <div class="col-md-3">
                                        <div class="slip-header <?php echo $this->Slips->getSlipClass() ?>">
                                            <div class="slip-header-container">
                                                <h1><?php echo $s->getSalary()->format('d/m/Y') ?></h1>

                                                <div class="actions">
                                                    <?php if (SlipsPolicy::isAuthorized('edit', $loggedUser)) { ?>
                                                        <?php echo $this->Html->link('<i class="fa fa-pencil fa-fw"></i>', ['action' => 'edit', $contract['id'], '?' => ['slip' => $s->getSalary()->format('d/m/Y')]], ['escape' => false, 'class' => 'btn btn-default']) ?>
                                                    <?php } ?>

                                                    <?php echo $this->Html->link('<i class="fa fa-usd fa-fw"></i>', '', ['escape' => false, 'class' => 'btn btn-default']) ?>
                                                    <?php echo $this->Slips->getReportButton($s->getSalary()->format('d/m/Y'), $companyData, $contract) ?>
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