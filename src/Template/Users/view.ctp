<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\User $user
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="users view large-9 medium-8 columns content">
    <h3><?= h($user->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nome') ?></th>
            <td><?= h($user->nome) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Username') ?></th>
            <td><?= h($user->username) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Password') ?></th>
            <td><?= h($user->password) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($user->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Endereco') ?></th>
            <td><?= h($user->endereco) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Numero') ?></th>
            <td><?= h($user->numero) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Complemento') ?></th>
            <td><?= h($user->complemento) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Bairro') ?></th>
            <td><?= h($user->bairro) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cidade') ?></th>
            <td><?= h($user->cidade) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Uf') ?></th>
            <td><?= h($user->uf) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cep') ?></th>
            <td><?= h($user->cep) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Identidade') ?></th>
            <td><?= h($user->identidade) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cpf Cnpj') ?></th>
            <td><?= h($user->cpf_cnpj) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Telefone 1') ?></th>
            <td><?= h($user->telefone_1) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Telefone 2') ?></th>
            <td><?= h($user->telefone_2) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Telefone 3') ?></th>
            <td><?= h($user->telefone_3) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Telefone 4') ?></th>
            <td><?= h($user->telefone_4) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Avatar') ?></th>
            <td><?= h($user->avatar) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($user->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Role') ?></th>
            <td><?= $this->Number->format($user->role) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Estado Civil') ?></th>
            <td><?= $this->Number->format($user->estado_civil) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($user->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Data Nascimento') ?></th>
            <td><?= h($user->data_nascimento) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Deleted') ?></th>
            <td><?= $user->deleted ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
