<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */

use App\Model\Custom\Recursivity;
use App\Policy\CustomBillsPolicy;

echo $this->Html->script('slips.min', ['block' => true]);
?>

<section class="content-header">
    <h1>
        <?php echo $this->Html->link('<i class="fa fa-arrow-left"></i>', $referrer, ['escape' => false]) ?>
        Contas do Contrato
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

    <?php echo $this->Form->create(null, ['url' => ['action' => 'add_recursive_fee', $contract['id']], 'id' => 'recursive-fee-form']) ?>

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Nova Taxa</h3>
        </div>

        <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                    <?php echo $this->Form->control('category', ['label' => 'Tipo', 'data-valids' => json_encode($jsonBills)]) ?>

                    <label class="error" id="category-error-label"></label>

                    <?php echo $this->Form->control('category_hidden', ['type' => 'hidden']) ?>
                </div>

                <div class="col-md-8">
                    <?php echo $this->Form->control('name', ['label' => 'Descrição']) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?php echo $this->Form->control('receiver', ['label' => 'Recebedor', 'options' => $receivers]) ?>
                </div>

                <div class="col-md-6">
                    <?php echo $this->Form->control('value', ['label' => 'Valor', 'class' => 'mask-money-negative']) ?>
                </div>
            </div>

            <label>Recursividade</label>

            <div class="radio">
                <label>
                    <input type="radio" name="recursive" id="recursive-all-option"
                           value="<?php echo Recursivity::RECURSIVITY_ALWAYS ?>"/>
                    <?php echo Recursivity::$recursions[Recursivity::RECURSIVITY_ALWAYS] ?>
                </label>
            </div>

            <div class="row">
                <div class="col-md-2">
                    <div class="radio">
                        <label>
                            <input type="radio" name="recursive" checked="checked" id="recursive-none-option"
                                   value="<?php echo Recursivity::RECURSION_NONE ?>"/>
                            <?php echo Recursivity::$recursions[Recursivity::RECURSION_NONE] ?>
                        </label>
                    </div>
                </div>

                <div class="col-md-4">
                    <?php echo $this->Form->control('specific_date', ['label' => false, 'class' => 'recursive-inputs date-picker']) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2">
                    <div class="radio">
                        <label>
                            <input type="radio" name="recursive" id="recursive-start-at-option"
                                   value="<?php echo Recursivity::RECURSION_START_AT ?>"/>
                            <?php echo Recursivity::$recursions[Recursivity::RECURSION_START_AT] ?>
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
                                   value="<?php echo Recursivity::RECURSION_PERIOD ?>"/>
                            <?php echo Recursivity::$recursions[Recursivity::RECURSION_PERIOD] ?>
                        </label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('period_start_date', ['label' => false, 'readonly' => true, 'class' => 'recursive-inputs date-picker']) ?>
                        </div>

                        <div class="col-md-6">
                            <?php echo $this->Form->control('period_end_date', ['label' => false, 'readonly' => true, 'class' => 'recursive-inputs date-picker']) ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php echo $this->Form->button('<i class="fa fa-plus"></i> Adicionar Taxa') ?>
        </div>
    </div>

    <?php echo $this->Form->end() ?>

    <div class="box">
        <div class="box-body">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Descrição</th>
                    <th>Recursividade</th>
                    <th class="to-right">Valor Atual</th>
                    <th class="to-center">Excluir</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($bills as $b) { ?>
                    <tr>
                        <td><?php echo $b->getName() ?></td>
                        <td><?php echo $b->getRecursivity() ?></td>
                        <td class="to-right"><?php echo $this->Slips->formatCurrency($b->getValue()) ?></td>
                        <td class="to-center">
                            <?php if (CustomBillsPolicy::isAuthorized('delete', $loggedUser, $b)) { ?>
                                <?php echo $this->Html->link('<i class="fa fa-trash"></i>', ['controller' => 'custom_bills', 'action' => 'delete', $b->getCustomBillId()], ['escape' => false, 'class' => 'btn btn-sm btn-danger', 'confirm' => 'Tem certeza que deseja excluir essa taxa?']) ?>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>