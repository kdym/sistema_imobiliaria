<?php

use App\Controller\BillsController;
use App\Policy\BillsPolicy;
use App\Policy\BrokersPolicy;
use App\Policy\CompanyDataPolicy;
use App\Policy\ConfigPolicy;
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
            $this->request->params['controller'] == 'Extract'
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

        if (
            $this->request->params['controller'] == 'Properties' ||
            $this->request->params['controller'] == 'LocatorsAssociations'
        ) {
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

        if (
            $this->request->params['controller'] == 'Contracts' ||
            $this->request->params['controller'] == 'Slips' ||
            $this->request->params['controller'] == 'SlipsCustomsValues' ||
            $this->request->params['controller'] == 'Guarantors'
        ) {
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

        if ($this->request->params['controller'] == 'Bills') {
            $active = 'active';
        }
        ?>

        <?php if (BillsPolicy::isAuthorized('index', $loggedUser)) { ?>
            <li class="<?php echo $active ?> treeview">
                <a href="#">
                    <i class="fa fa-envelope"></i> <span>Contas</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>

                        <small class="label pull-right bg-blue" id="total-bills-notification"></small>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php if (BillsPolicy::isAuthorized('water', $loggedUser)) { ?>
                        <?php
                        $active = '';

                        if ($this->request->params['action'] == 'water') {
                            $active = 'active';
                        }
                        ?>

                        <li>
                            <a href="<?php echo $this->Url->build(['controller' => 'bills', 'action' => 'water']) ?>"
                               class="<?php echo $active ?>">
                                <i class="fa fa-tint"></i> Água
                            </a>
                        </li>
                    <?php } ?>

                    <?php if (BillsPolicy::isAuthorized('absent', $loggedUser)) { ?>
                        <?php
                        $active = '';

                        if ($this->request->params['action'] == 'absent') {
                            $active = 'active';
                        }
                        ?>

                        <li>
                            <a href="<?php echo $this->Url->build(['controller' => 'bills', 'action' => 'absent']) ?>"
                               class="<?php echo $active ?>">
                                <i class="fa fa-times"></i> Ausentes

                                <span class="pull-right-container">
                                    <small class="label pull-right bg-yellow" id="absent-bills-notification"></small>
                                </span>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if (BillsPolicy::isAuthorized('toPay', $loggedUser)) { ?>
                        <?php
                        $active = '';

                        if ($this->request->params['action'] == 'toPay') {
                            $active = 'active';
                        }
                        ?>

                        <li>
                            <a href="<?php echo $this->Url->build(['controller' => 'bills', 'action' => 'to_pay']) ?>"
                               class="<?php echo $active ?>">
                                <i class="fa fa-usd"></i> A Pagar
                            </a>
                        </li>
                    <?php } ?>
                </ul>
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

        <?php
        $active = '';

        if (
            $this->request->params['controller'] == 'Config' ||
            $this->request->params['controller'] == 'CompanyData'
        ) {
            $active = 'active';
        }
        ?>

        <?php if (ConfigPolicy::isAuthorized('index', $loggedUser)) { ?>
            <li class="<?php echo $active ?>">
                <a href="<?php echo $this->Url->build(["controller" => "config", "action" => "index"]) ?>">
                    <i class="fa fa-cog"></i> <span>Configurações</span>
                </a>
            </li>
        <?php } ?>
    </ul>
<?php } ?>
