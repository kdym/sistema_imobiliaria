<?php

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
    </ul>
<?php } ?>
