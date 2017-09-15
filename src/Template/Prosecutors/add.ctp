<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Prosecutors'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Locators'), ['controller' => 'Locators', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Locator'), ['controller' => 'Locators', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="prosecutors form large-9 medium-8 columns content">
    <?= $this->Form->create($prosecutor) ?>
    <fieldset>
        <legend><?= __('Add Prosecutor') ?></legend>
        <?php
            echo $this->Form->control('user_id', ['options' => $users]);
            echo $this->Form->control('locator_id', ['options' => $locators]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
