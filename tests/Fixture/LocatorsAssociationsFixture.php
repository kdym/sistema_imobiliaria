<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LocatorsAssociationsFixture
 *
 */
class LocatorsAssociationsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'locator_1' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'locator_2' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'porcentagem' => ['type' => 'decimal', 'length' => 10, 'precision' => 2, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        '_indexes' => [
            'locator_1' => ['type' => 'index', 'columns' => ['locator_1'], 'length' => []],
            'locator_2' => ['type' => 'index', 'columns' => ['locator_2'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'locators_associations_ibfk_1' => ['type' => 'foreign', 'columns' => ['locator_1'], 'references' => ['locators', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'locators_associations_ibfk_2' => ['type' => 'foreign', 'columns' => ['locator_2'], 'references' => ['locators', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'latin1_swedish_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'locator_1' => 1,
            'locator_2' => 1,
            'porcentagem' => 1.5
        ],
    ];
}
