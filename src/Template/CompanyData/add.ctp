<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Company Data'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="companyData form large-9 medium-8 columns content">
    <?= $this->Form->create($companyData) ?>
    <fieldset>
        <legend><?= __('Add Company Data') ?></legend>
        <?php
            echo $this->Form->control('nome');
            echo $this->Form->control('razao_social');
            echo $this->Form->control('endereco');
            echo $this->Form->control('numero');
            echo $this->Form->control('complemento');
            echo $this->Form->control('bairro');
            echo $this->Form->control('cidade');
            echo $this->Form->control('uf');
            echo $this->Form->control('cep');
            echo $this->Form->control('cnpj');
            echo $this->Form->control('creci');
            echo $this->Form->control('abadi');
            echo $this->Form->control('telefone_1');
            echo $this->Form->control('telefone_2');
            echo $this->Form->control('telefone_3');
            echo $this->Form->control('email');
            echo $this->Form->control('latitude');
            echo $this->Form->control('longitude');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
