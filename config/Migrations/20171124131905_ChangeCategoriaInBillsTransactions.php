<?php
use Migrations\AbstractMigration;

class ChangeCategoriaInBillsTransactions extends AbstractMigration
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
        $table = $this->table('bills_transactions');

        $table->changeColumn('categoria', 'string', [
            'null' => false
        ]);

        $table->update();
    }
}
