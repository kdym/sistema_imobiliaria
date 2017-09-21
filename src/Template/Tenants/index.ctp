<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $ls
 */

use App\Policy\TenantsPolicy;

echo $this->Html->script('tenants.min', ['block' => true]);

?>
<section class="content-header">
    <h1>Locatários</h1>
</section>

<section class="content">
    <nav class="actions-bar">
        <?php echo $this->Html->link('<i class="fa fa-plus"></i> Novo', ['action' => 'form'], ['escape' => false, 'class' => 'btn btn-app']) ?>
    </nav>

    <div class="box">
        <div class="box-body">
            <table class="table table-hover" id="tenants-list">
                <thead>
                <tr>
                    <th>Usuário</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($tenants as $t) { ?>
                    <tr>
                        <td><?php echo $t['formatted_username'] ?></td>
                        <td><?php echo $this->Html->link($t['nome'], ['controller' => 'users', 'action' => 'view', $t['id']]) ?></td>
                        <td><?php echo $t['email'] ?></td>
                        <td>
                            <div class="actions-list">
                                <?php echo $this->Html->link('Editar', ['action' => 'form', $t['id']]) ?>

                                <?php if (TenantsPolicy::isAuthorized('delete', $loggedUser, $t)) { ?>
                                    <?php echo $this->Form->postLink('Excluir', ['action' => 'delete', $t['id']], ['confirm' => 'Tem certeza que deseja excluir?', 'method' => 'delete']) ?>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>