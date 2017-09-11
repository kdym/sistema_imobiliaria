<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */

use App\Model\Table\UsersTable;
use App\View\Helper\GlobalCombosHelper;


?>

    <section class="content-header">
        <h1>Locadores</h1>
    </section>

    <section class="content">
        <?php echo $this->Form->create($user, ['id' => 'locators-form']) ?>

        <div class="box">
            <div class="box-body">
                <?php echo $this->Form->control('nome') ?>

                <div class="row">
                    <div class="col-md-6">
                        <?php echo $this->Form->control('email', ['label' => 'E-mail']) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <?php echo $this->Form->control('cpf_cnpj', ['label' => 'CPF/CNPJ', 'class' => 'cpf-cnpj-mask']) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <?php echo $this->Form->control('identidade') ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <?php echo $this->Form->control('data_nascimento', ['label' => 'Data de Nascimento', 'class' => 'date-mask', 'type' => 'text']) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <?php echo $this->Form->control('estado_civil', ['options' => GlobalCombosHelper::$civilStates, 'empty' => true]) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="box" id="married-box" data-accepted-choice="<?php echo GlobalCombosHelper::CIVIL_STATE_MARRIED ?>">
            <div class="box-header">
                <h3 class="box-title">Dados do Cônjuge</h3>
            </div>

            <div class="box-body">
                <?php echo $this->Form->control('locator.nome_conjuge', ['label' => 'Nome']) ?>

                <div class="row">
                    <div class="col-md-6">
                        <?php echo $this->Form->control('locator.cpf_conjuge', ['label' => 'CPF', 'class' => 'cpf-mask']) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <?php echo $this->Form->control('locator.data_nascimento_conjuge', ['label' => 'Data de Nascimento', 'class' => 'date-mask', 'type' => 'text']) ?>
                    </div>
                </div>
            </div>
        </div>

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
            </div>
        </div>

        <div class="box">
            <div class="box-body">
                <?php for ($i = 1; $i <= UsersTable::MAX_PHONE_NUMBERS; $i++) { ?>
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo $this->Form->control("telefone_$i", ['class' => 'phone-ddd-mask']) ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <?php echo $this->Form->control('locator.banco', ['label' => 'Banco', 'options' => GlobalCombosHelper::$brazilianBanks, 'empty' => true]) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <?php echo $this->Form->control('locator.agencia', ['label' => 'Agência']) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <?php echo $this->Form->control('locator.conta', ['label' => 'Conta Corrente']) ?>
                    </div>
                </div>

                <?php echo $this->Form->control('locator.beneficiario', ['label' => 'Beneficiário']) ?>

                <?php echo $this->Form->control('locator.em_maos', ['label' => 'Entregar em Mãos']) ?>
            </div>
        </div>

        <?php if ($id) { ?>
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('username', ['label' => 'Usuário', 'class' => 'number-only']) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('locator.password', ['label' => 'Senha', 'type' => 'text']) ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php echo $this->Form->button('<i class="fa fa-check"></i> Salvar') ?>

        <?php echo $this->Form->end() ?>
    </section>

<?php echo $this->Html->script('locators.min', ['block' => true]) ?>