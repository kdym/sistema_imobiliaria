<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */

use App\Controller\BillsController;
use App\Model\Table\PropertiesTable;

echo $this->Html->script('bills.min', ['block' => true]);

?>

<section class="content-header">
    <h1>Contas Ausentes</h1>
</section>

<section class="content">
    <div class="box">
        <div class="box-body">
            <table id="bills-to-pay-list" class="table table-hover">
                <thead>
                <tr>
                    <th>Vencimento</th>
                    <th>Imóvel</th>
                    <th>Locatário</th>
                    <th>Conta</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($bills as $b) { ?>
                    <?php
                    $link = '';

                    switch ($b['type']) {
                        case PropertiesTable::BILL_WATER:
                            $link = ['controller' => 'bills', 'action' => 'water'];

                            break;
                    }
                    ?>

                    <tr>
                        <td><?php echo $b['salary']->format('d/m/Y') ?></td>
                        <td><?php echo sprintf('%s - %s', $b['property']['formatted_code'], $b['property']['full_address']) ?></td>
                        <td>
                            <?php
                            if (!empty($b['contract'])) {
                                echo sprintf('%s - %s', $this->Users->getUsername($b['contract']['tenant']['user']), $b['contract']['tenant']['user']['nome']);
                            } else {
                                echo 'Imóvel Vazio';
                            }
                            ?>
                        </td>
                        <td><?php echo PropertiesTable::$propertiesBills[$b['type']] ?></td>
                        <td>
                            <div class="actions-list">
                                <?php echo $this->Html->link('Lançar', $link, ['target' => '_blank']) ?>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>