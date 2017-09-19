<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $property->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $property->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Properties'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Locators'), ['controller' => 'Locators', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Locator'), ['controller' => 'Locators', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Properties Compositions'), ['controller' => 'PropertiesCompositions', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Properties Composition'), ['controller' => 'PropertiesCompositions', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Properties Fees'), ['controller' => 'PropertiesFees', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Properties Fee'), ['controller' => 'PropertiesFees', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Properties Prices'), ['controller' => 'PropertiesPrices', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Properties Price'), ['controller' => 'PropertiesPrices', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="properties form large-9 medium-8 columns content">
    <?= $this->Form->create($property) ?>
    <fieldset>
        <legend><?= __('Edit Property') ?></legend>
        <?php
            echo $this->Form->control('endereco');
            echo $this->Form->control('numero');
            echo $this->Form->control('complemento');
            echo $this->Form->control('bairro');
            echo $this->Form->control('cidade');
            echo $this->Form->control('uf');
            echo $this->Form->control('cep');
            echo $this->Form->control('deleted', ['empty' => true]);
            echo $this->Form->control('latitude');
            echo $this->Form->control('longitude');
            echo $this->Form->control('descricao');
            echo $this->Form->control('tipo');
            echo $this->Form->control('draft');
            echo $this->Form->control('codigo_saae');
            echo $this->Form->control('locator_id', ['options' => $locators, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
