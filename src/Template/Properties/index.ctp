<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $ls
 */

use App\Policy\PropertiesPolicy;
?>
<section class="content-header">
    <h1>Imóveis</h1>
</section>

<section class="content">
    <nav class="actions-bar">
        <?php echo $this->Html->link('<i class="fa fa-plus"></i> Novo', ['action' => 'form'], ['escape' => false, 'class' => 'btn btn-app']) ?>
    </nav>

    <div class="box">
        <div class="box-body">
            <div class="thumbs-list">
                <div class="row">
                    <?php foreach ($properties as $p) { ?>
                        <div class="col-md-3 col-sm-6">
                            <div class="item">
                                <div class="item-wrapper">
                                    <figure>
                                        <a href="<?php echo $this->Url->build(['action' => 'view', $p['id']]) ?>">
                                            <?php echo $this->Html->image($this->Properties->getMainPhoto($p)) ?>
                                        </a>
                                    </figure>

                                    <h1>
                                        <?php echo $this->Properties->getMainAddress($p) ?>
                                        <small><?php echo $p['formatted_code'] ?></small>
                                    </h1>

                                    <h2><?php echo $p['locator']['user']['nome'] ?>
                                        <small><?php echo $p['locator']['user']['formatted_username'] ?></small>
                                    </h2>

                                    <h3><?php echo $this->Properties->getStatus($p) ?></h3>
                                </div>

                                <nav class="actions">
                                    <?php if (PropertiesPolicy::isAuthorized('form', $loggedUser, $p)) { ?>
                                        <?php echo $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'form', $p['id']], ['escape' => false, 'class' => 'btn btn-primary']) ?>
                                    <?php } ?>

                                    <?php if (PropertiesPolicy::isAuthorized('delete', $loggedUser, $p)) { ?>
                                        <?php echo $this->Form->postLink('<i class="fa fa-trash"></i>', ['action' => 'delete', $p['id']], ['escape' => false, 'class' => 'btn btn-danger', 'confirm' => 'Tem certeza que deseja excluir?', 'method' => 'delete']) ?>
                                    <?php } ?>
                                </nav>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <?php echo $this->Pagination->buildPagination($this->Paginator) ?>
</section>