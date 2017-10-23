<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $bs
 * @var \App\Model\Custom\GeneralFee $f
 */

use App\Model\Table\ContractsValuesTable;

?>

<section class="content-header">
    <h1>Configurações</h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Dados da Imobiliária</h3>

                    <div class="box-tools pull-right">
                        <?php echo $this->Html->link('<i class="fa fa-pencil"></i>', ['controller' => 'company_data', 'action' => 'index'], ['escape' => false]) ?>
                    </div>
                </div>

                <div class="box-body">
                    <?php if (!$companyData) { ?>
                        <div class="alert alert-warning">
                            Não há dados da imobliária cadastrados no momento. Favor cadastrar
                        </div>
                    <?php } else { ?>
                        <div class="icon-view-list">
                            <div class="item">
                                <div class="icon">
                                    <i class="fa fa-building"></i>
                                </div>

                                <div class="value">
                                    <h1><?php echo $companyData['nome'] ?></h1>

                                    <h2><?php echo $companyData['razao_social'] ?></h2>

                                    <h3><?php echo $companyData['cnpj'] ?></h3>
                                </div>
                            </div>

                            <div class="item">
                                <div class="icon">
                                    <i class="fa fa-phone"></i>
                                </div>

                                <div class="value">
                                    <h1>Contato</h1>

                                    <h2>
                                        <?php
                                        echo implode(' / ', array_filter([
                                            $companyData['telefone_1'],
                                            $companyData['telefone_2'],
                                            $companyData['telefone_3'],
                                        ]))
                                        ?>
                                    </h2>

                                    <h3><?php echo $companyData['email'] ?></h3>
                                </div>
                            </div>

                            <?php if (!empty($companyData['creci'])) { ?>
                                <div class="item">
                                    <div class="icon">
                                        <i class="fa fa-id-card-o"></i>
                                    </div>

                                    <div class="value">
                                        <h1>CRECI</h1>

                                        <h2><?php echo $companyData['creci'] ?></h2>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if (!empty($companyData['abadi'])) { ?>
                                <div class="item">
                                    <div class="icon">
                                        <i class="fa fa-id-card-o"></i>
                                    </div>

                                    <div class="value">
                                        <h1>ABADI</h1>

                                        <h2><?php echo $companyData['abadi'] ?></h2>
                                    </div>
                                </div>
                            <?php } ?>

                            <div class="item">
                                <div class="icon">
                                    <i class="fa fa-map-marker"></i>
                                </div>

                                <div class="value">
                                    <h2>
                                        <?php echo implode(', ', array_filter([
                                            $companyData['endereco'],
                                            $companyData['numero'],
                                            $companyData['complemento'],
                                        ])) ?>
                                    </h2>

                                    <h3>
                                        <?php echo implode(', ', [
                                            $companyData['bairro'],
                                            $companyData['cidade'],
                                            $companyData['uf'],
                                        ]) ?>
                                    </h3>

                                    <h4><?php echo $companyData['cep'] ?></h4>
                                </div>
                            </div>

                            <div class="item">
                                <div class="icon">
                                    <i class="fa fa-university"></i>
                                </div>

                                <div class="value">
                                    <h1>Agência/Código Cedente</h1>

                                    <h2><?php echo $companyData['agencia'] ?></h2>

                                    <h3><?php echo sprintf("%s-%s", $companyData['codigo_cedente'], $companyData['codigo_cedente_dv']) ?></h3>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Parâmetros Gerais</h3>

                    <div class="box-tools pull-right">
                        <?php echo $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'general'], ['escape' => false]) ?>
                    </div>
                </div>

                <div class="box-body">
                    <div class="icon-view-list">
                        <?php foreach (ContractsValuesTable::$generalFees as $f) { ?>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>