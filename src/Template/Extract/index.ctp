<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */

use App\Model\Custom\ExtractPropertyValue;
use App\Model\Table\ExtractsTable;
use App\Policy\ExtractPolicy;

echo $this->Html->css('contracts.min', ['block' => true]);

?>

<section class="content-header">
    <h1>Extrato
        <small><?php echo $locator['user']['nome'] ?></small>
    </h1>
</section>

<section class="content">
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

    <div class="box">
        <div class="box-body">
            <div id="slips-info">
                <?php $period = new DatePeriod($startDate, new DateInterval('P1M'), $endDate); ?>

                <?php foreach ($period as $p) { ?>
                    <div class="slip">
                        <div class="row equal-height-row">
                            <div class="col-md-3">
                                <div class="slip-header bg-primary">
                                    <div class="slip-header-container">
                                        <h1><?php echo $this->Slips->monthInWords($p->format('m')) ?></h1>

                                        <h2><?php echo $p->format('Y') ?></h2>

                                        <div class="actions">
                                            <?php if (ExtractPolicy::isAuthorized('report', $loggedUser)) { ?>
                                                <?php echo $this->Html->link('<i class="fa fa-print fa-fw"></i>', '', ['escape' => false, 'class' => 'btn btn-default', 'title' => 'Visualizar Extrato', 'data-toggle' => 'tooltip']) ?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-9">
                                <div class="slip-body">
                                    <?php foreach ($locator['properties'] as $pr) { ?>
                                        <table class="table table-hover extract-tables">
                                            <thead>
                                            <tr>
                                                <th colspan="4"><?php echo $pr['full_address'] ?></th>
                                            </tr>
                                            <tr>
                                                <th colspan="4">
                                                    <?php
                                                    if (!empty($pr['active_contract'])) {
                                                        echo sprintf('Locatário: %s - %s', $pr['active_contract']['tenant']['user']['formatted_username'], $pr['active_contract']['tenant']['user']['nome']);
                                                    } else {
                                                        echo 'Imóvel Vazio';
                                                    }
                                                    ?>
                                                </th>
                                            </tr>
                                            <tr class="columns-header">
                                                <th width="10%">Data</th>
                                                <th>Histórico</th>
                                                <th width="15%" class="to-right">Crédito</th>
                                                <th width="15%" class="to-right">Débito</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $sumCredit = $sumDebit = 0; ?>
                                            <?php if (!empty($extracts[$p->format('Y-m')][$pr['id']])) { ?>
                                                <?php foreach ($extracts[$p->format('Y-m')][$pr['id']] as $v) { ?>
                                                    <?php
                                                    $credit = $debit = 0;

                                                    if ($v['tipo'] == ExtractsTable::IN) {
                                                        $credit = $v['valor'];
                                                    } else {
                                                        $debit = $v['valor'];
                                                    }

                                                    $sumCredit += $credit;
                                                    $sumDebit += $debit;
                                                    ?>

                                                    <tr>
                                                        <td><?php echo $v['data'] ?></td>
                                                        <td><?php echo $v['descricao'] ?></td>
                                                        <td class="to-right"><?php echo $this->Slips->formatCurrency($credit) ?></td>
                                                        <td class="to-right"><?php echo $this->Slips->formatCurrency($debit) ?></td>
                                                    </tr>
                                                <?php } ?>
                                            <?php } ?>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <td colspan="2">Total do Imóvel</td>
                                                <td class="to-right"><?php echo $this->Slips->formatCurrency($sumCredit) ?></td>
                                                <td class="to-right"><?php echo $this->Slips->formatCurrency($sumDebit) ?></td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    <?php } ?>

                                    <!--                                    --><?php
                                    //                                    $lastBalanceIn = $lastBalanceOut = 0;
                                    //                                    $currentBalanceIn = $currentBalanceOut = 0;
                                    //
                                    //                                    if ($e->getLastBalance() < 0) {
                                    //                                        $lastBalanceOut = abs($e->getLastBalance());
                                    //                                    } else {
                                    //                                        $lastBalanceIn = $e->getLastBalance();
                                    //                                    }
                                    //
                                    //                                    if ($e->getCurrentBalance() < 0) {
                                    //                                        $currentBalanceOut = abs($e->getCurrentBalance());
                                    //                                    } else {
                                    //                                        $currentBalanceIn = $e->getCurrentBalance();
                                    //                                    }
                                    //                                    ?>
                                    <!---->
                                    <!--                                    <table class="table">-->
                                    <!--                                        <tr>-->
                                    <!--                                            <th>Saldo do mês anterior</th>-->
                                    <!--                                            <td width="15%"-->
                                    <!--                                                class="to-right">-->
                                    <?php //echo $this->Slips->formatCurrency($lastBalanceIn) ?><!--</td>-->
                                    <!--                                            <td width="15%"-->
                                    <!--                                                class="to-right">-->
                                    <?php //echo $this->Slips->formatCurrency($lastBalanceOut) ?><!--</td>-->
                                    <!--                                        </tr>-->
                                    <!--                                        <tr>-->
                                    <!--                                            <th>Saldo do extrato</th>-->
                                    <!--                                            <td width="15%"-->
                                    <!--                                                class="to-right">-->
                                    <?php //echo $this->Slips->formatCurrency($currentBalanceIn) ?><!--</td>-->
                                    <!--                                            <td width="15%"-->
                                    <!--                                                class="to-right">-->
                                    <?php //echo $this->Slips->formatCurrency($currentBalanceOut) ?><!--</td>-->
                                    <!--                                        </tr>-->
                                    <!--                                    </table>-->
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>