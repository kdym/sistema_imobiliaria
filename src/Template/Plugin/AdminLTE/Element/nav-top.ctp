<?php

use Cake\Core\Configure;

$file = Configure::read('Theme.folder') . DS . 'src' . DS . 'Template' . DS . 'Element' . DS . 'nav-top.ctp';

if (file_exists($file)) {
    ob_start();
    include_once $file;
    echo ob_get_clean();
} else {
    ?>
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-cog"></i> <span class="hidden-xs"><?php echo $loggedUser['nome'] ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <p>
                                <?php echo $loggedUser['nome'] ?>
                                <small><?php echo \App\Model\Table\UsersTable::$roles[$loggedUser['role']] ?></small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?php echo $this->Url->build(['controller' => 'users', 'action' => 'profile']) ?>"
                                   class="btn btn-default btn-flat">Perfil</a>
                            </div>
                            <div class="pull-right">
                                <?php echo $this->Html->link('Sair', ['controller' => 'users', 'action' => 'logout'], ['class' => 'btn btn-default btn-flat']) ?>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <?php
}
?>
