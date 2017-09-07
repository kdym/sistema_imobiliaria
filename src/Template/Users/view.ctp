<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */

use \App\Model\Table\UsersTable;
use App\Policy\BrokersPolicy;
use App\Policy\UsersPolicy;

$editLink = '';


if (UsersPolicy::isAuthorized('form', $loggedUser, $user)) {
    $editLink = ['controller' => 'users', 'action' => 'form', $user['id']];
}

//if (LocatorsPolicy::isAuthorized('form', $loggedUser, $user)) {
//    $editLink = ['controller' => 'locators', 'action' => 'form', $user['id']];
//}
//
//if (TenantsPolicy::isAuthorized('form', $loggedUser, $user)) {
//    $editLink = ['controller' => 'tenants', 'action' => 'form', $user['id']];
//}

if (BrokersPolicy::isAuthorized('form', $loggedUser, $user)) {
    $editLink = ['controller' => 'brokers', 'action' => 'form', $user['id']];
}

if (UsersPolicy::isAuthorized('show_edit_profile', $loggedUser, $user)) {
    $editLink = ['controller' => 'users', 'action' => 'profile'];
}
?>

<section class="content-header">
    <h1>Usuários</h1>
</section>

<section class="content">
    <?php if ($user['deleted'] != null) { ?>
        <div class="alert alert-warning">
            <i class="fa fa-exclamation-triangle"></i> Esse usuário foi excluído
            em <?php echo $user['deleted']->format('d/m/Y') ?>
        </div>
    <?php } ?>

    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Dados Pessoais</h3>

                    <div class="box-tools pull-right">
                        <?php echo $this->Html->link('<i class="fa fa-pencil"></i>', $editLink, ['escape' => false]) ?>
                    </div>
                </div>

                <div class="box-body">
                    <div class="icon-view-list">
                        <div class="item">
                            <div class="icon">
                                <i class="fa fa-user"></i>
                            </div>

                            <div class="value">
                                <h1><?php echo $this->Users->getUsername($user) ?></h1>

                                <h2><?php echo $user['nome'] ?></h2>
                            </div>
                        </div>

                        <div class="item">
                            <div class="icon">
                                <i class="fa fa-sitemap"></i>
                            </div>

                            <div class="value">
                                <h1>Perfil</h1>

                                <h2><?php echo $this->Users->getRole($user) ?></h2>
                            </div>
                        </div>

                        <div class="item">
                            <div class="icon">
                                <i class="fa fa-calendar"></i>
                            </div>

                            <div class="value">
                                <h1>Criado em</h1>

                                <h2><?php echo $user['created']->format('d/m/Y') ?></h2>
                            </div>
                        </div>

                        <?php if (!empty($user['broker'])) { ?>
                            <div class="item">
                                <div class="icon">
                                    <i class="fa fa-percent"></i>
                                </div>

                                <div class="value">
                                    <h1>Comissão</h1>

                                    <h2><?php echo $this->Brokers->getComission($user['broker']) ?></h2>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="item">
                            <div class="icon">
                                <i class="fa fa-envelope"></i>
                            </div>

                            <div class="value">
                                <h1>E-mail</h1>

                                <h2><?php echo $user['email'] ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Endereço e Contato</h3>

                    <div class="box-tools pull-right">
                        <?php echo $this->Html->link('<i class="fa fa-pencil"></i>', $editLink, ['escape' => false]) ?>
                    </div>
                </div>

                <div class="box-body">
                    <div class="icon-view-list">
                        <div class="item">
                            <div class="icon">
                                <i class="fa fa-map-marker"></i>
                            </div>

                            <div class="value">
                                <?php if (!$this->Users->hasAddress($user)) { ?>
                                    <h2>Nenhum endereço cadastrado</h2>
                                <?php } else { ?>
                                    <h2>
                                        <?php echo implode(', ', array_filter([
                                            $user['endereco'],
                                            $user['numero'],
                                            $user['complemento'],
                                        ])) ?>
                                    </h2>

                                    <h3>
                                        <?php echo implode(', ', [
                                            $user['bairro'],
                                            $user['cidade'],
                                            $user['uf'],
                                        ]) ?>
                                    </h3>

                                    <h4><?php echo $user['cep'] ?></h4>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <ul class="vertical-icon-list">
                        <?php for ($i = 1; $i <= UsersTable::MAX_PHONE_NUMBERS; $i++) { ?>
                            <?php if (!empty($user["telefone_$i"])) { ?>
                                <li><i class="fa fa-phone"></i> <?php echo $user["telefone_$i"] ?></li>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>