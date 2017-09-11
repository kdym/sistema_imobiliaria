<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Locators'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="locators form large-9 medium-8 columns content">
    <?= $this->Form->create($locator) ?>
    <fieldset>
        <legend><?= __('Add Locator') ?></legend>
        <?php
            echo $this->Form->control('nome_conjuge');
            echo $this->Form->control('cpf_conjuge');
            echo $this->Form->control('data_nascimento_conjuge');
            echo $this->Form->control('agencia');
            echo $this->Form->control('conta');
            echo $this->Form->control('beneficiario');
            echo $this->Form->control('password');
            echo $this->Form->control('em_maos');
            echo $this->Form->control('user_id', ['options' => $users]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
