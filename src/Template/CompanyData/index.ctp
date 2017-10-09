<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */

use App\View\Helper\GlobalCombosHelper;

echo $this->Html->script('company-data.min', ['block' => true]);
?>

<section class="content-header">
    <h1>Dados da Imobiliária</h1>
</section>

<section class="content">
    <?php echo $this->Form->create($companyData, ['type' => 'file']) ?>

    <div class="box">
        <div class="box-body">
            <?php echo $this->Form->control('nome') ?>

            <?php echo $this->Form->control('razao_social', ['label' => 'Razão Social']) ?>

            <div class="row">
                <div class="col-md-6">
                    <?php echo $this->Form->control('email', ['label' => 'E-mail']) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?php echo $this->Form->control('cnpj', ['label' => 'CNPJ', 'class' => 'cnpj-mask']) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?php echo $this->Form->control('creci', ['label' => 'CRECI']) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?php echo $this->Form->control('abadi', ['label' => 'ABADI']) ?>
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
            <?php for ($i = 1; $i <= 3; $i++) { ?>
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
                    <?php echo $this->Form->control('agencia', ['label' => 'Agência', 'class' => 'number-only']) ?>
                </div>
            </div>

            <label>Código Cedente - DV</label>

            <div class="row">
                <div class="col-md-5 col-sm-10 col-xs-10">
                    <?php echo $this->Form->control('codigo_cedente', ['label' => false, 'class' => 'number-only']) ?>
                </div>

                <div class="col-md-1 col-sm-2 col-xs-2">
                    <?php echo $this->Form->control('codigo_cedente_dv', ['label' => false, 'class' => 'number-only']) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <?php if (file_exists(WWW_ROOT . 'file/logo.png')) { ?>
                        <figure class="form-img">
                            <?php echo $this->Html->link('<i class="fa fa-trash"></i>', ['action' => 'delete_logo'], ['class' => 'btn btn-danger btn-sm', 'escape' => false, 'confirm' => 'Tem certeza que deseja excluir?']) ?>

                            <?php echo $this->Html->image('/file/logo.png', ['class' => 'img-responsive']) ?>
                        </figure>
                    <?php } ?>

                    <?php echo $this->Form->control('logo', ['type' => 'file']) ?>
                </div>

                <div class="col-md-6">
                    <?php if (file_exists(WWW_ROOT . 'file/logo_small.png')) { ?>
                        <figure class="form-img">
                            <?php echo $this->Html->link('<i class="fa fa-trash"></i>', ['action' => 'delete_small_logo'], ['class' => 'btn btn-danger btn-sm', 'escape' => false, 'confirm' => 'Tem certeza que deseja excluir?']) ?>

                            <?php echo $this->Html->image('/file/logo_small.png', ['class' => 'img-responsive']) ?>
                        </figure>
                    <?php } ?>

                    <?php echo $this->Form->control('logo_small', ['label' => 'Logo Pequeno', 'type' => 'file']) ?>
                </div>
            </div>
        </div>
    </div>

    <?php echo $this->Form->button('<i class="fa fa-check"></i> Salvar') ?>

    <?php echo $this->Form->end() ?>
</section>