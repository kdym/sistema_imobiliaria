<?php

use App\Policy\BrokersPolicy;
use App\Policy\ContractsPolicy;
use App\Policy\LocatorsPolicy;
use App\Policy\PropertiesPolicy;
use App\Policy\TenantsPolicy;
use App\Policy\UsersPolicy;
use Cake\Core\Configure;

$file = Configure::read('Theme.folder') . DS . 'src' . DS . 'Template' . DS . 'Element' . DS . 'aside' . DS . 'sidebar-menu.ctp';
if (file_exists($file)) {
    ob_start();
    include_once $file;
    echo ob_get_clean();
} else {
    ?>
    <ul class="sidebar-menu">
        <li class="header">Menu</li>

        <li><a href="/"><i class="fa fa-tachometer"></i> <span>Resumo</span></a></li>

        <?php
        $active = '';

        if ($this->request->params['controller'] == 'Brokers') {
            $active = 'active';
        }
        ?>

        <?php if (BrokersPolicy::isAuthorized('index', $loggedUser)) { ?>
            <li class="<?php echo $active ?>">
                <a href="<?php echo $this->Url->build(["controller" => "brokers", "action" => "index"]) ?>">
                    <i class="fa fa-users"></i> <span>Corretores</span>
                </a>
            </li>
        <?php } ?>

        <?php
        $active = '';

        if (
            $this->request->params['controller'] == 'Locators' ||
            $this->request->params['controller'] == 'LocatorsAssociations'
        ) {
            $active = 'active';
        }
        ?>

        <?php if (LocatorsPolicy::isAuthorized('index', $loggedUser)) { ?>
            <li class="<?php echo $active ?>">
                <a href="<?php echo $this->Url->build(["controller" => "locators", "action" => "index"]) ?>">
                    <i class="fa fa-users"></i> <span>Locadores</span>
                </a>
            </li>
        <?php } ?>

        <?php
        $active = '';

        if ($this->request->params['controller'] == 'Properties') {
            $active = 'active';
        }
        ?>

        <?php if (PropertiesPolicy::isAuthorized('index', $loggedUser)) { ?>
            <li class="<?php echo $active ?>">
                <a href="<?php echo $this->Url->build(["controller" => "properties", "action" => "index"]) ?>">
                    <i class="fa fa-home"></i> <span>Imóveis</span>
                </a>
            </li>
        <?php } ?>

        <?php
        $active = '';

        if ($this->request->params['controller'] == 'Tenants') {
            $active = 'active';
        }
        ?>

        <?php if (TenantsPolicy::isAuthorized('index', $loggedUser)) { ?>
            <li class="<?php echo $active ?>">
                <a href="<?php echo $this->Url->build(["controller" => "tenants", "action" => "index"]) ?>">
                    <i class="fa fa-users"></i> <span>Locatários</span>
                </a>
            </li>
        <?php } ?>

        <?php
        $active = '';

        if ($this->request->params['controller'] == 'Contracts') {
            $active = 'active';
        }
        ?>

        <?php if (ContractsPolicy::isAuthorized('index', $loggedUser)) { ?>
            <li class="<?php echo $active ?>">
                <a href="<?php echo $this->Url->build(["controller" => "contracts", "action" => "index"]) ?>">
                    <i class="fa fa-file-text"></i> <span>Contratos</span>
                </a>
            </li>
        <?php } ?>

        <?php
        $active = '';

        if ($this->request->params['controller'] == 'Users') {
            $active = 'active';
        }
        ?>

        <?php if (UsersPolicy::isAuthorized('index', $loggedUser)) { ?>
            <li class="<?php echo $active ?>">
                <a href="<?php echo $this->Url->build(["controller" => "users", "action" => "index"]) ?>">
                    <i class="fa fa-users"></i> <span>Usuários</span>
                </a>
            </li>
        <?php } ?>
    </ul>
<?php } ?>
