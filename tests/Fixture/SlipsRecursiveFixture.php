<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SlipsRecursiveFixture
 *
 */
class SlipsRecursiveFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'slips_recursive';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'start_date' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'end_date' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'deleted' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'slip_custom_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'tipo' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'contract_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'valor' => ['type' => 'decimal', 'length' => 10, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        '_indexes' => [
            'slip_custom_id' => ['type' => 'index', 'columns' => ['slip_custom_id'], 'length' => []],
            'contract_id' => ['type' => 'index', 'columns' => ['contract_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'slips_recursive_ibfk_1' => ['type' => 'foreign', 'columns' => ['slip_custom_id'], 'references' => ['slips_custom_values', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'slips_recursive_ibfk_2' => ['type' => 'foreign', 'columns' => ['contract_id'], 'references' => ['contracts', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
            'start_date' => '2017-10-11',
            'end_date' => '2017-10-11',
            'deleted' => 1,
            'slip_custom_id' => 1,
            'tipo' => 'Lorem ipsum dolor sit amet',
            'contract_id' => 1,
            'valor' => 1.5
        ],
    ];
}
