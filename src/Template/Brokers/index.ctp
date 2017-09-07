<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $bs
 */

use App\Policy\BrokersPolicy;


?>
    <section class="content-header">
        <h1>Corretores</h1>
    </section>

    <section class="content">
        <nav class="actions-bar">
            <?php echo $this->Html->link('<i class="fa fa-plus"></i> Novo', ['action' => 'form'], ['escape' => false, 'class' => 'btn btn-app']) ?>
        </nav>

        <div class="box">
            <div class="box-body">
                <table class="table table-hover" id="brokers-list">
                    <thead>
                    <tr>
                        <th>Usuário</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($brokers as $b) { ?>
                        <tr>
                            <td><?php echo $this->Users->getUsername($b) ?></td>
                            <td><?php echo $this->Html->link($b['nome'], ['controller' => 'users', 'action' => 'view', $b['id']]) ?></td>
                            <td><?php echo $b['email'] ?></td>
                            <td class="to-center">
                                <div class="actions-list">
                                    <?php echo $this->Html->link('Editar', ['action' => 'form', $b['id']]) ?>

                                    <?php if (BrokersPolicy::isAuthorized('delete', $loggedUser, $b)) { ?>
                                        <?php echo $this->Form->postLink('Excluir', ['action' => 'delete', $b['id']], ['confirm' => 'Tem certeza que deseja excluir?', 'method' => 'delete']) ?>
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

<?php echo $this->Html->script('brokers.min', ['block' => true]) ?>