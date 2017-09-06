<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */

use \App\Model\Table\UsersTable;
use App\Policy\UsersPolicy;

?>
    <section class="content-header">
        <h1>Usuários</h1>
    </section>

    <section class="content">
        <nav class="actions-bar">
            <?php echo $this->Html->link('<i class="fa fa-plus"></i> Novo', ['action' => 'form'], ['escape' => false, 'class' => 'btn btn-app']) ?>
        </nav>

        <div class="box">
            <div class="box-body">
                <table class="table table-hover" id="users-list">
                    <thead>
                    <tr>
                        <th>Usuário</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Perfil</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($users as $user) { ?>
                        <tr class="<?php echo $this->Users->getClassFlag($user) ?>">
                            <td><?php echo $this->Users->getUsername($user) ?></td>
                            <td><?php echo $this->Html->link($user['nome'], ['action' => 'view', $user['id']]) ?></td>
                            <td><?php echo $user['email'] ?></td>
                            <td><?php echo $this->Users->getRole($user) ?></td>
                            <td class="to-center">
                                <div class="actions-list">
                                    <?php echo $this->Html->link('Editar', ['action' => 'form', $user['id']]) ?>

                                    <?php if (UsersPolicy::isAuthorized('delete', $loggedUser, $user)) { ?>
                                        <?php echo $this->Form->postLink('Excluir', ['action' => 'delete', $user['id']], ['confirm' => 'Tem certeza que deseja excluir?', 'method' => 'delete']) ?>
                                    <?php } ?>

                                    <?php if (UsersPolicy::isAuthorized('undelete', $loggedUser, $user)) { ?>
                                        <?php echo $this->Form->postLink('Reativar', ['action' => 'undelete', $user['id']], ['confirm' => 'Tem certeza que deseja reativar?', 'method' => 'put']) ?>
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

<?php echo $this->Html->script('users.min', ['block' => true]) ?>