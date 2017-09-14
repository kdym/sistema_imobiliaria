<?php

use Migrations\AbstractMigration;

class CreateLocatorsAssociations extends AbstractMigration
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
        $table = $this->table('locators_associations');
        $table->addColumn('locator_1', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->addForeignKey('locator_1', 'users', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE']);
        $table->addColumn('locator_2', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->addForeignKey('locator_2', 'users', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE']);
        $table->addColumn('porcentagem', 'decimal', [
            'default' => null,
            'precision' => 10,
            'scale' => 2,
            'null' => true,
        ]);
        $table->create();
    }
}
