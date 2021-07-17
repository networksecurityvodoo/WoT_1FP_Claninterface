<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TanksFixture
 */
class TanksFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'name' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'tier' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'tankType_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'expDef' => ['type' => 'decimal', 'length' => 8, 'precision' => 3, 'unsigned' => false, 'null' => false, 'default' => '0.000', 'comment' => ''],
        'expFrag' => ['type' => 'decimal', 'length' => 8, 'precision' => 3, 'unsigned' => false, 'null' => false, 'default' => '0.000', 'comment' => ''],
        'expSpot' => ['type' => 'decimal', 'length' => 8, 'precision' => 3, 'unsigned' => false, 'null' => false, 'default' => '0.000', 'comment' => ''],
        'expDamage' => ['type' => 'decimal', 'length' => 8, 'precision' => 3, 'unsigned' => false, 'null' => false, 'default' => '0.000', 'comment' => ''],
        'expWinRate' => ['type' => 'decimal', 'length' => 8, 'precision' => 3, 'unsigned' => false, 'null' => false, 'default' => '0.000', 'comment' => ''],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'nation' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'premium' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8mb4_unicode_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd
    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'tier' => 1,
                'tankType_id' => 1,
                'expDef' => 1.5,
                'expFrag' => 1.5,
                'expSpot' => 1.5,
                'expDamage' => 1.5,
                'expWinRate' => 1.5,
                'created' => '2021-02-09 21:50:52',
                'modified' => '2021-02-09 21:50:52',
                'nation' => 'Lorem ipsum dolor sit amet',
                'premium' => 1,
            ],
        ];
        parent::init();
    }
}
