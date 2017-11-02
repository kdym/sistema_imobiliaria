<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $ls
 */

use App\Policy\PropertiesPolicy;

echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.2/jquery.matchHeight-min.js', ['block' => true]);
echo $this->Html->script('initializers/match-height.min', ['block' => true]);
?>
<section class="content-header">
    <h1>Contratos</h1>
</section>

<section class="content">
    <nav class="actions-bar">
        <?php echo $this->Html->link('<i class="fa fa-plus"></i> Novo', ['action' => 'form'], ['escape' => false, 'class' => 'btn btn-app']) ?>
    </nav>

    <div class="box">
        <div class="box-body">
            <div class="thumbs-list">
                <div class="row">
                    <?php foreach ($contracts as $c) { ?>
                        <div class="col-md-3 col-sm-6">
                            <div class="item">
                                <div class="item-wrapper">
                                    <figure>
                                        <a href="<?php echo $this->Url->build(['action' => 'view', $c['id']]) ?>">
                                            <?php echo $this->Html->image($this->Properties->getMainPhoto($c['property'])) ?>
                                        </a>
                                    </figure>

                                    <h1>
                                        <?php echo $this->Properties->getMainAddress($c['property']) ?>
                                        <small><?php echo $c['property']['formatted_code'] ?></small>
                                    </h1>

                                    <h2><?php echo $c['tenant']['user']['nome'] ?>
                                        <small><?php echo $c['tenant']['user']['formatted_username'] ?></small>
                                    </h2>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <?php echo $this->Pagination->buildPagination($this->Paginator) ?>
</section>