<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="users index large-9 medium-8 columns content">
    <h3><?= __('Users') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nome') ?></th>
                <th scope="col"><?= $this->Paginator->sort('username') ?></th>
                <th scope="col"><?= $this->Paginator->sort('password') ?></th>
                <th scope="col"><?= $this->Paginator->sort('email') ?></th>
                <th scope="col"><?= $this->Paginator->sort('role') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('endereco') ?></th>
                <th scope="col"><?= $this->Paginator->sort('numero') ?></th>
                <th scope="col"><?= $this->Paginator->sort('complemento') ?></th>
                <th scope="col"><?= $this->Paginator->sort('bairro') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cidade') ?></th>
                <th scope="col"><?= $this->Paginator->sort('uf') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cep') ?></th>
                <th scope="col"><?= $this->Paginator->sort('identidade') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cpf_cnpj') ?></th>
                <th scope="col"><?= $this->Paginator->sort('estado_civil') ?></th>
                <th scope="col"><?= $this->Paginator->sort('telefone_1') ?></th>
                <th scope="col"><?= $this->Paginator->sort('telefone_2') ?></th>
                <th scope="col"><?= $this->Paginator->sort('telefone_3') ?></th>
                <th scope="col"><?= $this->Paginator->sort('telefone_4') ?></th>
                <th scope="col"><?= $this->Paginator->sort('data_nascimento') ?></th>
                <th scope="col"><?= $this->Paginator->sort('avatar') ?></th>
                <th scope="col"><?= $this->Paginator->sort('deleted') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $this->Number->format($user->id) ?></td>
                <td><?= h($user->nome) ?></td>
                <td><?= h($user->username) ?></td>
                <td><?= h($user->password) ?></td>
                <td><?= h($user->email) ?></td>
                <td><?= $this->Number->format($user->role) ?></td>
                <td><?= h($user->created) ?></td>
                <td><?= h($user->endereco) ?></td>
                <td><?= h($user->numero) ?></td>
                <td><?= h($user->complemento) ?></td>
                <td><?= h($user->bairro) ?></td>
                <td><?= h($user->cidade) ?></td>
                <td><?= h($user->uf) ?></td>
                <td><?= h($user->cep) ?></td>
                <td><?= h($user->identidade) ?></td>
                <td><?= h($user->cpf_cnpj) ?></td>
                <td><?= $this->Number->format($user->estado_civil) ?></td>
                <td><?= h($user->telefone_1) ?></td>
                <td><?= h($user->telefone_2) ?></td>
                <td><?= h($user->telefone_3) ?></td>
                <td><?= h($user->telefone_4) ?></td>
                <td><?= h($user->data_nascimento) ?></td>
                <td><?= h($user->avatar) ?></td>
                <td><?= h($user->deleted) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $user->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>
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
