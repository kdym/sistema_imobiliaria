<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */

use App\Model\Table\UsersTable;
use App\View\Helper\GlobalCombosHelper;

echo $this->Html->script('guarantors.min', ['block' => true]);

?>

<section class="content-header">
    <h1>
        <a href="<?php echo $referrer ?>"><i class="fa fa-arrow-left"></i></a>
        Fiadores
        <small><?php echo $contract['property']['full_address'] ?></small>
    </h1>
</section>

<section class="content">
    <?php if (!$id) { ?>
        <div class="box collapsed-box" id="search-users-box">
            <div class="box-header with-border">
                <h3 class="box-title">Buscar</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>

            <div class="box-body">
                <?php echo $this->Form->control('search_user', ['label' => false]) ?>
            </div>
        </div>
    <?php } ?>

    <?php echo $this->Form->create($guarantor) ?>

    <?php echo $this->Form->control('contract_id', ['type' => 'hidden', 'value' => $contract['id']]) ?>

    <div class="box">
        <?php if (!$id) { ?>
            <div class="box-header with-border">
                <h3 class="box-title">Cadastrar novo</h3>
            </div>
        <?php } ?>

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

            <?php echo $this->Form->control('profissao', ['label' => 'Profissão']) ?>
            <?php echo $this->Form->control('nacionalidade') ?>

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
            <?php echo $this->Form->control('spouse.nome', ['label' => 'Nome']) ?>

            <div class="row">
                <div class="col-md-6">
                    <?php echo $this->Form->control('spouse.cpf', ['label' => 'CPF', 'class' => 'cpf-mask']) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?php echo $this->Form->control('spouse.data_nascimento', ['label' => 'Data de Nascimento', 'class' => 'date-mask', 'type' => 'text']) ?>
                </div>
            </div>
        </div>
    </div>

    <?php if ($id) { ?>
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <?php echo $this->Form->control('username', ['label' => 'Usuário']) ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

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

    <?php echo $this->Form->button('<i class="fa fa-check"></i> Salvar') ?>

    <?php echo $this->Form->end() ?>
</section>

<script type="text/html" id="users-search-template">
    <p>${name}
        <small>${username}</small>
    </p>
</script>