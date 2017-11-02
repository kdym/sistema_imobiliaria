<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $bs
 * @var \App\Model\Custom\GeneralFee $f
 */

use App\Model\Table\ContractsTable;
use App\Model\Table\ContractsValuesTable;

$editLink = ['action' => 'form', $contract['id']];

?>

<section class="content-header">
    <h1>Contratos</h1>
</section>

<section class="content">
    <nav class="actions-bar">
        <?php echo $this->Html->link('<i class="fa fa-barcode"></i> Boletos', ['controller' => 'slips', 'action' => 'index', $contract['id']], ['escape' => false, 'class' => 'btn btn-app']) ?>
<!--        --><?php //echo $this->Html->link('<i class="fa fa-usd"></i> Extrato', ['controller' => 'extract', 'action' => 'index', $contract['property']['locator_id']], ['escape' => false, 'class' => 'btn btn-app']) ?>
    </nav>

    <div class="masonry-list-50">
        <div class="box masonry-sizer-50">
            <div class="box-header with-border">
                <h3 class="box-title">Dados do Contrato</h3>

                <div class="box-tools pull-right">
                    <?php echo $this->Html->link('<i class="fa fa-pencil"></i>', $editLink, ['escape' => false]) ?>
                </div>
            </div>

            <div class="box-body">
                <div class="icon-view-list">
                    <div class="item">
                        <div class="icon">
                            <?php echo $this->Html->image($this->Properties->getMainPhoto($contract['property']), ['class' => 'img-responsive img-rounded']) ?>
                        </div>

                        <div class="value">
                            <h1><?php echo $contract['property']['formatted_code'] ?></h1>

                            <h2>
                                <?php
                                echo implode(', ', array_filter([
                                    $contract['property']['endereco'],
                                    $contract['property']['numero'],
                                    $contract['property']['complemento'],
                                ]))
                                ?>
                            </h2>

                            <h3>
                                <?php
                                echo implode(', ', array_filter([
                                    $contract['property']['bairro'],
                                    $contract['property']['cidade'],
                                    $contract['property']['uf'],
                                ]))
                                ?>
                            </h3>

                            <h4><?php echo $contract['property']['cep'] ?></h4>
                        </div>
                    </div>

                    <div class="item">
                        <div class="icon">
                            <i class="fa fa-user"></i>
                        </div>

                        <div class="value">
                            <h1>Locador</h1>

                            <h2><?php echo $contract['property']['locator']['user']['nome'] ?></h2>

                            <h3><?php echo $contract['property']['locator']['user']['formatted_username'] ?></h3>
                        </div>
                    </div>

                    <div class="item">
                        <div class="icon">
                            <i class="fa fa-user"></i>
                        </div>

                        <div class="value">
                            <h1>Locatário</h1>

                            <h2><?php echo $contract['tenant']['user']['nome'] ?></h2>

                            <h3><?php echo $contract['tenant']['user']['formatted_username'] ?></h3>
                        </div>
                    </div>

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
                            <i class="fa fa-file-text"></i>
                        </div>

                        <div class="value">
                            <h1>Finalidade</h1>

                            <h2><?php echo $this->Contracts->getFinality($contract) ?></h2>

                            <?php if ($contract['finalidade'] == ContractsTable::FINALITY_NON_RESIDENTIAL) { ?>
                                <h3><?php echo $contract['finalidade_nao_residencial'] ?></h3>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="box masonry-sizer-50">
            <div class="box-header with-border">
                <h3 class="box-title">Taxas</h3>

                <div class="box-tools pull-right">
                    <?php echo $this->Html->link('<i class="fa fa-pencil"></i>', $editLink, ['escape' => false]) ?>
                </div>
            </div>

            <div class="icon-view-list">
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
                        <h1>Taxa Contratual</h1>

                        <h2><?php echo $this->Contracts->getContractualFee($contract) ?></h2>
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

                <?php foreach (ContractsValuesTable::$generalFees as $f) { ?>
                    <?php if (!empty($contract['contracts_values'][0][$f->getKey()])) { ?>
                        <div class="item">
                            <div class="icon">
                                <i class="fa fa-<?php echo $f->getIcon() ?>"></i>
                            </div>

                            <div class="value">
                                <h1><?php echo $f->getName() ?></h1>

                                <h2><?php echo $f->getFormattedValue() ?></h2>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>

        <div class="box masonry-sizer-50">
            <div class="box-header with-border">
                <h3 class="box-title">Vencimentos</h3>

                <div class="box-tools pull-right">
                    <?php echo $this->Html->link('<i class="fa fa-pencil"></i>', $editLink, ['escape' => false]) ?>
                </div>
            </div>

            <div class="icon-view-list">
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
            </div>
        </div>

        <div class="box masonry-sizer-50">
            <div class="box-header with-border">
                <h3 class="box-title">Posse/Devolução</h3>

                <div class="box-tools pull-right">
                    <?php echo $this->Html->link('<i class="fa fa-pencil"></i>', $editLink, ['escape' => false]) ?>
                </div>
            </div>

            <div class="box-body">
                <div class="icon-view-list">
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
    </div>
</section>