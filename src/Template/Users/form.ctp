<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */

use \App\Model\Table\UsersTable;

?>

    <section class="content-header">
        <h1>Usuários</h1>
    </section>

    <section class="content">
        <?php echo $this->Form->create($user) ?>

        <div class="box">
            <div class="box-body">
                <?php echo $this->Form->control('nome') ?>

                <div class="row">
                    <div class="col-md-6">
                        <?php echo $this->Form->control('username', ['label' => 'Usuário']) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <?php echo $this->Form->control('email', ['label' => 'E-mail']) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <?php echo $this->Form->control('role', ['label' => 'Perfil', 'options' => UsersTable::$roles]) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="box">
            <div class="box-body">
                <?php for ($i = 1; $i <= UsersTable::MAX_PHONE_NUMBERS; $i++) { ?>
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo $this->Form->control("telefone_$i", ['class' => 'phone-ddd-mask']) ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="box">
            <div class="box-body">
                <?php if ($id) { ?>
                    <?php echo $this->Form->control('change_password', ['label' => 'Trocar Senha', 'type' => 'checkbox']) ?>

                    <div class="row">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('new_password', ['type' => 'password', 'label' => 'Senha', 'readonly' => true]) ?>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('password', ['label' => 'Senha']) ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <?php echo $this->Form->button('<i class="fa fa-check"></i> Salvar') ?>

        <?php echo $this->Form->end() ?>
    </section>

<?php echo $this->Html->script('users.min', ['block' => true]) ?>