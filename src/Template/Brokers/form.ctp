<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */

use App\Model\Table\UsersTable;
use App\View\Helper\GlobalCombosHelper;


?>

    <section class="content-header">
        <h1>Corretores</h1>
    </section>

    <section class="content">
        <?php echo $this->Form->create($user) ?>

        <div class="box">
            <div class="box-body">
                <?php echo $this->Form->control('nome') ?>

                <div class="row">
                    <div class="col-md-6">
                        <?php echo $this->Form->control('username', ['label' => 'Usuário']) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <?php echo $this->Form->control('email', ['label' => 'E-mail']) ?>
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

        <?php if (!$id) { ?>
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('password', ['label' => 'Senha']) ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <div class="box">
            <div class="box-body">
                <label>Comissão</label>

                <div class="row">
                    <div class="col-md-6">
                        <?php echo $this->Form->control('broker.tipo_comissao', ['label' => false, 'options' => GlobalCombosHelper::$comissionTypes, 'default' => GlobalCombosHelper::COMISSION_TYPE_PERCENTAGE]) ?>
                    </div>

                    <div class="col-md-6">
                        <?php echo $this->Form->control('broker.comissao', ['label' => false, 'class' => 'mask-number', 'type' => 'text']) ?>
                    </div>
                </div>
            </div>
        </div>

        <?php echo $this->Form->button('<i class="fa fa-check"></i> Salvar') ?>

        <?php echo $this->Form->end() ?>
    </section>

<?php echo $this->Html->script('brokers.min', ['block' => true]) ?>