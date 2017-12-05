<?php
use Migrations\AbstractMigration;

class CreatePropertiesPhotos extends AbstractMigration
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
        $table = $this->table('properties_photos');
        $table->addColumn('url', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('ordem', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->addColumn('property_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->addForeignKey('property_id', 'properties', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE']);
        $table->create();
    }
}
