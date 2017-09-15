<?php

use Migrations\AbstractMigration;

class ChangeKeysInLocatorsAssociations extends AbstractMigration
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


        $table->dropForeignKey('locator_1');
        $table->removeColumn('locator_1');

        $table->dropForeignKey('locator_2');
        $table->removeColumn('locator_2');

        $table->addColumn('locator_1', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addForeignKey('locator_1', 'locators', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE']);

        $table->addColumn('locator_2', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addForeignKey('locator_2', 'locators', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE']);

        $table->update();
    }
}
