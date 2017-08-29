<?php

use Cake\Core\Configure;

$file = Configure::read('Theme.folder') . DS . 'src' . DS . 'Template' . DS . 'Element' . DS . 'footer.ctp';

if (file_exists($file)) {
    ob_start();
    include_once $file;
    echo ob_get_clean();
} else {
    ?>
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Versão</b> <?php echo $this->Version->getVersionInfo() ?>
        </div>
        <strong><a href="http://kdymsolucoes.com.br" target="_blank">Kdym Soluções em Tecnologia</a></strong>
    </footer>
<?php } ?>
