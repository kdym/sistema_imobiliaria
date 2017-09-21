<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $ls
 */

use App\Policy\LocatorsPolicy;


?>
    <section class="content-header">
        <h1>Locadores</h1>
    </section>

    <section class="content">
        <nav class="actions-bar">
            <?php echo $this->Html->link('<i class="fa fa-plus"></i> Novo', ['action' => 'form'], ['escape' => false, 'class' => 'btn btn-app']) ?>
        </nav>

        <div class="box">
            <div class="box-body">
                <table class="table table-hover" id="locators-list">
                    <thead>
                    <tr>
                        <th>Usuário</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($locators as $l) { ?>
                        <tr>
                            <td><?php echo $l['formatted_username'] ?></td>
                            <td><?php echo $this->Html->link($l['nome'], ['controller' => 'users', 'action' => 'view', $l['id']]) ?></td>
                            <td><?php echo $l['email'] ?></td>
                            <td>
                                <div class="actions-list">
                                    <?php echo $this->Html->link('Editar', ['action' => 'form', $l['id']]) ?>

                                    <?php if (LocatorsPolicy::isAuthorized('delete', $loggedUser, $l)) { ?>
                                        <?php echo $this->Form->postLink('Excluir', ['action' => 'delete', $l['id']], ['confirm' => 'Tem certeza que deseja excluir?', 'method' => 'delete']) ?>
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

<?php echo $this->Html->script('locators.min', ['block' => true]) ?>