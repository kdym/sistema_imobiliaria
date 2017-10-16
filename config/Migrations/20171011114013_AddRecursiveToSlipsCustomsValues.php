<?php

use Migrations\AbstractMigration;

class AddRecursiveToSlipsCustomsValues extends AbstractMigration
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
        $table = $this->table('slips_customs_values');

        $table->addColumn('recursive_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->addForeignKey('recursive_id', 'recursive', 'id', ['delete' => 'SET NULL', 'update' => 'SET NULL']);

        $table->update();
    }
}
