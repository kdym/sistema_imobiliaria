<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Add User') ?></legend>
        <?php
            echo $this->Form->control('nome');
            echo $this->Form->control('username');
            echo $this->Form->control('password');
            echo $this->Form->control('email');
            echo $this->Form->control('role');
            echo $this->Form->control('endereco');
            echo $this->Form->control('numero');
            echo $this->Form->control('complemento');
            echo $this->Form->control('bairro');
            echo $this->Form->control('cidade');
            echo $this->Form->control('uf');
            echo $this->Form->control('cep');
            echo $this->Form->control('identidade');
            echo $this->Form->control('cpf_cnpj');
            echo $this->Form->control('estado_civil');
            echo $this->Form->control('telefone_1');
            echo $this->Form->control('telefone_2');
            echo $this->Form->control('telefone_3');
            echo $this->Form->control('telefone_4');
            echo $this->Form->control('data_nascimento');
            echo $this->Form->control('avatar');
            echo $this->Form->control('deleted');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
