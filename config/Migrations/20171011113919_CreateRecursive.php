<?php
use Migrations\AbstractMigration;

class CreateRecursive extends AbstractMigration
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
        $table = $this->table('recursive');
        $table->addColumn('dia', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('mes', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('ano', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('start_date', 'date', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('end_date', 'date', [
            'default' => null,
            'null' => true,
        ]);
        $table->create();
    }
}
