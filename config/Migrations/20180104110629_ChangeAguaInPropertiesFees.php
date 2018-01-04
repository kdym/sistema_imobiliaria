<?php

use Migrations\AbstractMigration;

class ChangeAguaInPropertiesFees extends AbstractMigration
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
        $table = $this->table('properties_fees');

        $table->removeColumn('agua');
        $table->addColumn('agua', 'integer', [
            'default' => null,
            'null' => true,
        ]);

        $table->update();
    }
}
