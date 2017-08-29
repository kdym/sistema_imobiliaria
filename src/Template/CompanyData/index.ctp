<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\CompanyData[]|\Cake\Collection\CollectionInterface $companyData
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Company Data'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="companyData index large-9 medium-8 columns content">
    <h3><?= __('Company Data') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nome') ?></th>
                <th scope="col"><?= $this->Paginator->sort('razao_social') ?></th>
                <th scope="col"><?= $this->Paginator->sort('endereco') ?></th>
                <th scope="col"><?= $this->Paginator->sort('numero') ?></th>
                <th scope="col"><?= $this->Paginator->sort('complemento') ?></th>
                <th scope="col"><?= $this->Paginator->sort('bairro') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cidade') ?></th>
                <th scope="col"><?= $this->Paginator->sort('uf') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cep') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cnpj') ?></th>
                <th scope="col"><?= $this->Paginator->sort('creci') ?></th>
                <th scope="col"><?= $this->Paginator->sort('abadi') ?></th>
                <th scope="col"><?= $this->Paginator->sort('telefone_1') ?></th>
                <th scope="col"><?= $this->Paginator->sort('telefone_2') ?></th>
                <th scope="col"><?= $this->Paginator->sort('telefone_3') ?></th>
                <th scope="col"><?= $this->Paginator->sort('email') ?></th>
                <th scope="col"><?= $this->Paginator->sort('latitude') ?></th>
                <th scope="col"><?= $this->Paginator->sort('longitude') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($companyData as $companyData): ?>
            <tr>
                <td><?= $this->Number->format($companyData->id) ?></td>
                <td><?= h($companyData->nome) ?></td>
                <td><?= h($companyData->razao_social) ?></td>
                <td><?= h($companyData->endereco) ?></td>
                <td><?= h($companyData->numero) ?></td>
                <td><?= h($companyData->complemento) ?></td>
                <td><?= h($companyData->bairro) ?></td>
                <td><?= h($companyData->cidade) ?></td>
                <td><?= h($companyData->uf) ?></td>
                <td><?= h($companyData->cep) ?></td>
                <td><?= h($companyData->cnpj) ?></td>
                <td><?= h($companyData->creci) ?></td>
                <td><?= h($companyData->abadi) ?></td>
                <td><?= h($companyData->telefone_1) ?></td>
                <td><?= h($companyData->telefone_2) ?></td>
                <td><?= h($companyData->telefone_3) ?></td>
                <td><?= h($companyData->email) ?></td>
                <td><?= h($companyData->latitude) ?></td>
                <td><?= h($companyData->longitude) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $companyData->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $companyData->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $companyData->id], ['confirm' => __('Are you sure you want to delete # {0}?', $companyData->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
