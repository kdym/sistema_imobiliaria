<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Broker $broker
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Broker'), ['action' => 'edit', $broker->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Broker'), ['action' => 'delete', $broker->id], ['confirm' => __('Are you sure you want to delete # {0}?', $broker->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Brokers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Broker'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="brokers view large-9 medium-8 columns content">
    <h3><?= h($broker->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $broker->has('user') ? $this->Html->link($broker->user->id, ['controller' => 'Users', 'action' => 'view', $broker->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($broker->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tipo Comissao') ?></th>
            <td><?= $this->Number->format($broker->tipo_comissao) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Comissao') ?></th>
            <td><?= $this->Number->format($broker->comissao) ?></td>
        </tr>
    </table>
</div>
