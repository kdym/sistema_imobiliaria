<?php
use Migrations\AbstractMigration;

class ChangeCategoriaInCustomBills extends AbstractMigration
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
        $table = $this->table('custom_bills');

        $table->changeColumn('categoria', 'string', [
            'null' => false
        ]);
        $table->changeColumn('pagante', 'string', [
            'null' => false
        ]);
        $table->changeColumn('recebedor', 'string', [
            'null' => false
        ]);

        $table->update();
    }
}
