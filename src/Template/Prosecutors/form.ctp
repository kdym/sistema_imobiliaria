<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */

use App\Model\Table\UsersTable;
use App\View\Helper\GlobalCombosHelper;

echo $this->Html->script('prosecutors.min', ['block' => true]);

?>

<section class="content-header">
    <h1>Procuradores
        <small><?php echo $locator['user']['nome'] ?></small>
    </h1>
</section>

<section class="content">
    <?php if (!$id) { ?>
        <div class="box collapsed-box" id="search-prosecutors-box">
            <div class="box-header with-border">
                <h3 class="box-title">Buscar</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>

            <div class="box-body">
                <?php echo $this->Form->control('search_prosecutor', ['label' => false]) ?>
            </div>
        </div>
    <?php } ?>

    <?php echo $this->Form->create($prosecutor) ?>

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

<?php echo $this->Form->control('locator_id', ['type' => 'hidden', 'value' => $locator['id']]) ?>
<?php echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => $locator['user']['id']]) ?>

<script type="text/html" id="prosecutors-search-template">
    <p>${name}
        <small>${username}</small>
    </p>
</script>