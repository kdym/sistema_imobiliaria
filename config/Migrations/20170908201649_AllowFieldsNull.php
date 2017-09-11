<?php

use Migrations\AbstractMigration;

class AllowFieldsNull extends AbstractMigration
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
        $table = $this->table('locators');

        $table->changeColumn('data_nascimento_conjuge', 'date', [
            'null' => true,
        ]);

        $table->update();
    }
}
