<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */

$this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js', ['block' => true]);

$this->Html->script('users.min', ['block' => true]);

use \App\Model\Table\UsersTable;
use App\Policy\BrokersPolicy;
use App\Policy\LocatorsAssociationsPolicy;
use App\Policy\LocatorsPolicy;
use App\Policy\PropertiesPolicy;
use App\Policy\ProsecutorsPolicy;
use App\Policy\TenantsPolicy;
use App\Policy\UsersPolicy;

$editLink = '';

if (UsersPolicy::isAuthorized('form', $loggedUser, $user)) {
    $editLink = ['controller' => 'users', 'action' => 'form', $user['id']];
}

if (LocatorsPolicy::isAuthorized('form', $loggedUser, $user)) {
    $editLink = ['controller' => 'locators', 'action' => 'form', $user['id']];
}

if (TenantsPolicy::isAuthorized('form', $loggedUser, $user)) {
    $editLink = ['controller' => 'tenants', 'action' => 'form', $user['id']];
}

if (BrokersPolicy::isAuthorized('form', $loggedUser, $user)) {
    $editLink = ['controller' => 'brokers', 'action' => 'form', $user['id']];
}

if (ProsecutorsPolicy::isAuthorized('edit', $loggedUser, $user)) {
    $editLink = ['controller' => 'prosecutors', 'action' => 'form', $user['prosecutor']['locator_id'], $user['prosecutor']['id']];
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

    <div class="masonry-list-50">
        <div class="box masonry-sizer-50">
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

                            <?php if (!empty($user['cpf_cnpj'])) { ?>
                                <h3><?php echo $user['cpf_cnpj'] ?></h3>
                            <?php } ?>
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

                    <?php if (!empty($user['locator']['password'])) { ?>
                        <div class="item">
                            <div class="icon">
                                <i class="fa fa-key"></i>
                            </div>

                            <div class="value">
                                <h1>Senha Visível</h1>

                                <h2><?php echo $user['locator']['password'] ?></h2>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if (!empty($user['identidade'])) { ?>
                        <div class="item">
                            <div class="icon">
                                <i class="fa fa-id-card-o"></i>
                            </div>

                            <div class="value">
                                <h1>Identidade</h1>

                                <h2><?php echo $user['identidade'] ?></h2>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if (!empty($user['locator'])) { ?>
                        <div class="item">
                            <div class="icon">
                                <i class="fa fa-heart"></i>
                            </div>

                            <div class="value">
                                <h1>Estado Civil</h1>

                                <h2><?php echo $this->Users->getCivilState($user) ?></h2>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if (!empty($user['data_nascimento'])) { ?>
                        <div class="item">
                            <div class="icon">
                                <i class="fa fa-birthday-cake"></i>
                            </div>

                            <div class="value">
                                <h1>Data de Nascimento</h1>

                                <h2><?php echo $user['data_nascimento'] ?></h2>
                            </div>
                        </div>
                    <?php } ?>

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

        <div class="box masonry-sizer-50">
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
                            <?php
                            $userAddress = [];

                            if ($user['role'] == UsersTable::ROLE_TENANT) {
                                if (!empty($user['tenant']['active_contract'])) {
                                    $userAddress = [
                                        'address' => $user['tenant']['active_contract']['property']['endereco'],
                                        'number' => $user['tenant']['active_contract']['property']['numero'],
                                        'complement' => $user['tenant']['active_contract']['property']['complemento'],
                                        'neighborhood' => $user['tenant']['active_contract']['property']['bairro'],
                                        'city' => $user['tenant']['active_contract']['property']['cidade'],
                                        'state' => $user['tenant']['active_contract']['property']['uf'],
                                        'zip' => $user['tenant']['active_contract']['property']['cep'],
                                    ];
                                }
                            } else {
                                if (!empty($user['endereco'])) {
                                    $userAddress = [
                                        'address' => $user['endereco'],
                                        'number' => $user['numero'],
                                        'complement' => $user['complemento'],
                                        'neighborhood' => $user['bairro'],
                                        'city' => $user['cidade'],
                                        'state' => $user['uf'],
                                        'zip' => $user['cep'],
                                    ];
                                }
                            }
                            ?>

                            <?php if (empty($userAddress)) { ?>
                                <h2>Nenhum endereço cadastrado</h2>
                            <?php } else { ?>
                                <h2>
                                    <?php echo implode(', ', array_filter([
                                        $userAddress['address'],
                                        $userAddress['number'],
                                        $userAddress['complement'],
                                    ])) ?>
                                </h2>

                                <h3>
                                    <?php echo implode(', ', [
                                        $userAddress['neighborhood'],
                                        $userAddress['city'],
                                        $userAddress['state'],
                                    ]) ?>
                                </h3>

                                <h4><?php echo $userAddress['zip'] ?></h4>
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

        <?php if ($this->Locators->hasSpouse($user['locator'])) { ?>
            <div class="box masonry-sizer-50">
                <div class="box-header with-border">
                    <h3 class="box-title">Dados do Cônjuge</h3>

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
                                <h2><?php echo $user['locator']['nome_conjuge'] ?></h2>

                                <h3><?php echo $user['locator']['cpf_conjuge'] ?></h3>
                            </div>
                        </div>

                        <div class="item">
                            <div class="icon">
                                <i class="fa fa-birthday-cake"></i>
                            </div>

                            <div class="value">
                                <h1>Data de Nascimento</h1>

                                <h2><?php echo $user['locator']['data_nascimento_conjuge'] ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php if (!empty($user['locator'])) { ?>
            <div class="box masonry-sizer-50">
                <div class="box-header with-border">
                    <h3 class="box-title">Dados Bancários</h3>

                    <div class="box-tools pull-right">
                        <?php echo $this->Html->link('<i class="fa fa-pencil"></i>', $editLink, ['escape' => false]) ?>
                    </div>
                </div>

                <div class="box-body">
                    <div class="icon-view-list">
                        <div class="item">
                            <div class="icon">
                                <i class="fa fa-university"></i>
                            </div>

                            <div class="value">
                                <?php if ($user['locator']['em_maos'] == true) { ?>
                                    <h1>Banco</h1>

                                    <h2>Entregar em mãos</h2>
                                <?php } else { ?>
                                    <h1><?php echo $this->Locators->getBank($user['locator']) ?></h1>

                                    <h2>Agência: <?php echo $user['locator']['agencia'] ?></h2>

                                    <h3>Conta: <?php echo $user['locator']['conta'] ?></h3>
                                <?php } ?>
                            </div>
                        </div>

                        <?php if (!empty($user['locator']['beneficiario'])) { ?>
                            <div class="item">
                                <div class="icon">
                                    <i class="fa fa-user"></i>
                                </div>

                                <div class="value">
                                    <h1>Beneficiário</h1>

                                    <h2><?php echo $user['locator']['beneficiario'] ?></h2>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="box masonry-sizer-50">
                <div class="box-header with-border">
                    <h3 class="box-title">Locadores Associados</h3>

                    <?php if (LocatorsAssociationsPolicy::isAuthorized('form', $loggedUser)) { ?>
                        <div class="box-tools pull-right">
                            <?php echo $this->Html->link('<i class="fa fa-pencil"></i>', ['controller' => 'locators_associations', 'action' => 'form', $user['id']], ['escape' => false]) ?>
                        </div>
                    <?php } ?>
                </div>

                <div class="box-body">
                    <canvas id="locators-associations-chart" class="graph-container"
                            data-dataset='<?php echo json_encode($locatorsAssociationsDataset['dataset']) ?>'
                            data-labels='<?php echo json_encode($locatorsAssociationsDataset['labels']) ?>'
                            data-colors='<?php echo json_encode($locatorsAssociationsDataset['colors']) ?>'></canvas>
                </div>
            </div>

            <div class="box masonry-sizer-50">
                <div class="box-header with-border">
                    <h3 class="box-title">Procuradores</h3>

                    <?php if (ProsecutorsPolicy::isAuthorized('form', $loggedUser)) { ?>
                        <div class="box-tools pull-right">
                            <?php echo $this->Html->link('<i class="fa fa-plus"></i>', ['controller' => 'prosecutors', 'action' => 'form', $user['locator']['id']], ['escape' => false]) ?>
                        </div>
                    <?php } ?>
                </div>

                <div class="box-body">
                    <?php if (!empty($user['locator']['prosecutors'])) { ?>
                        <ul class="vertical-icon-list">
                            <?php foreach ($user['locator']['prosecutors'] as $p) { ?>
                                <li>
                                    <i class="fa fa-user"></i> <?php echo $p['user']['nome'] ?>
                                    <small><?php echo $p['user']['formatted_username'] ?></small>

                                    <div class="pull-right">
                                        <?php if (ProsecutorsPolicy::isAuthorized('edit', $loggedUser, $p['user'])) { ?>
                                            <?php echo $this->Html->link('<i class="fa fa-pencil"></i>', ['controller' => 'prosecutors', 'action' => 'form', $user['locator']['id'], $p['id']], ['escape' => false]) ?>
                                        <?php } ?>

                                        <?php if (ProsecutorsPolicy::isAuthorized('delete', $loggedUser)) { ?>
                                            <?php echo $this->Form->postLink('<i class="fa fa-trash"></i>', ['controller' => 'prosecutors', 'action' => 'delete', $p['id']], ['escape' => false, 'class' => 'text-danger', 'confirm' => 'Tem certeza que deseja excluir?', 'method' => 'delete']) ?>
                                        <?php } ?>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>

        <?php if (!empty($user['prosecutors'])) { ?>
            <div class="box masonry-sizer-50">
                <div class="box-header with-border">
                    <h3 class="box-title">Procurador de</h3>
                </div>

                <div class="box-body">
                    <div class="icon-view-list">
                        <?php foreach ($user['prosecutors'] as $p) { ?>
                            <div class="item">
                                <div class="icon">
                                    <i class="fa fa-user"></i>
                                </div>

                                <div class="value">
                                    <h1><?php echo $p['locator']['user']['formatted_username'] ?></h1>

                                    <h2><?php echo $p['locator']['user']['nome'] ?></h2>

                                    <h3>
                                        <?php if (ProsecutorsPolicy::isAuthorized('delete', $loggedUser)) { ?>
                                            <?php echo $this->Form->postLink('<i class="fa fa-trash"></i>', ['controller' => 'prosecutors', 'action' => 'delete', $p['id']], ['escape' => false, 'class' => 'text-danger', 'confirm' => 'Tem certeza que deseja excluir?', 'method' => 'delete']) ?>
                                        <?php } ?>
                                    </h3>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php if (!empty($user['locator']['properties'])) { ?>
            <div class="box masonry-sizer-100">
                <div class="box-header">
                    <h3 class="box-title">Imóveis</h3>
                </div>

                <div class="box-body">
                    <div class="thumbs-list">
                        <div class="row">
                            <?php foreach ($user['locator']['properties'] as $p) { ?>
                                <div class="col-md-3 col-sm-6">
                                    <div class="item">
                                        <div class="item-wrapper">
                                            <figure>
                                                <a href="<?php echo $this->Url->build(['controller' => 'properties', 'action' => 'view', $p['id']]) ?>">
                                                    <?php echo $this->Html->image($this->Properties->getMainPhoto($p)) ?>
                                                </a>
                                            </figure>

                                            <h1>
                                                <?php echo $this->Properties->getMainAddress($p) ?>
                                                <small><?php echo $p['formatted_code'] ?></small>
                                            </h1>

                                            <h3><?php echo $this->Properties->getStatus($p) ?></h3>
                                        </div>

                                        <nav class="actions">
                                            <?php if (PropertiesPolicy::isAuthorized('form', $loggedUser, $p)) { ?>
                                                <?php echo $this->Html->link('<i class="fa fa-pencil"></i>', ['controller' => 'properties', 'action' => 'form', $p['id']], ['escape' => false, 'class' => 'btn btn-primary']) ?>
                                            <?php } ?>

                                            <?php if (PropertiesPolicy::isAuthorized('delete', $loggedUser, $p)) { ?>
                                                <?php echo $this->Form->postLink('<i class="fa fa-trash"></i>', ['controller' => 'properties', 'action' => 'delete', $p['id']], ['escape' => false, 'class' => 'btn btn-danger', 'confirm' => 'Tem certeza que deseja excluir?', 'method' => 'delete']) ?>
                                            <?php } ?>
                                        </nav>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</section>