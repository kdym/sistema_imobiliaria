<?php

use Cake\Core\Configure;

$file = Configure::read('Theme.folder') . DS . 'src' . DS . 'Template' . DS . 'Element' . DS . 'aside' . DS . 'user-panel.ctp';

if (file_exists($file)) {
    ob_start();
    include_once $file;
    echo ob_get_clean();
} else {
    ?>
    <div class="user-panel">
        <div class="info">
            <h4><?php echo $loggedUser['nome'] ?></h4>
        </div>
    </div>
<?php } ?>
