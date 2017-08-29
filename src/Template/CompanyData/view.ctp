<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\CompanyData $companyData
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Company Data'), ['action' => 'edit', $companyData->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Company Data'), ['action' => 'delete', $companyData->id], ['confirm' => __('Are you sure you want to delete # {0}?', $companyData->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Company Data'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Company Data'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="companyData view large-9 medium-8 columns content">
    <h3><?= h($companyData->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nome') ?></th>
            <td><?= h($companyData->nome) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Razao Social') ?></th>
            <td><?= h($companyData->razao_social) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Endereco') ?></th>
            <td><?= h($companyData->endereco) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Numero') ?></th>
            <td><?= h($companyData->numero) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Complemento') ?></th>
            <td><?= h($companyData->complemento) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Bairro') ?></th>
            <td><?= h($companyData->bairro) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cidade') ?></th>
            <td><?= h($companyData->cidade) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Uf') ?></th>
            <td><?= h($companyData->uf) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cep') ?></th>
            <td><?= h($companyData->cep) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cnpj') ?></th>
            <td><?= h($companyData->cnpj) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Creci') ?></th>
            <td><?= h($companyData->creci) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Abadi') ?></th>
            <td><?= h($companyData->abadi) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Telefone 1') ?></th>
            <td><?= h($companyData->telefone_1) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Telefone 2') ?></th>
            <td><?= h($companyData->telefone_2) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Telefone 3') ?></th>
            <td><?= h($companyData->telefone_3) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($companyData->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Latitude') ?></th>
            <td><?= h($companyData->latitude) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Longitude') ?></th>
            <td><?= h($companyData->longitude) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($companyData->id) ?></td>
        </tr>
    </table>
</div>
