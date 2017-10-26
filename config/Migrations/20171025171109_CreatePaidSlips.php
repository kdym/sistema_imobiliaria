<?php
use Migrations\AbstractMigration;

class CreatePaidSlips extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('paid_slips');
        $table->addColumn('vencimento', 'date', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('data_pago', 'date', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('contract_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->addForeignKey('contract_id', 'contracts', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE']);
        $table->create();
    }
}
