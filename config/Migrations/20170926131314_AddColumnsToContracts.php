<?php

use Migrations\AbstractMigration;

class AddColumnsToContracts extends AbstractMigration
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
        $table = $this->table('contracts');
        $table->addColumn('data_posse', 'date', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('data_devolucao', 'date', [
            'default' => null,
            'null' => true,
        ]);
        $table->update();
    }
}
