<?php

namespace DivideByZero\AutoStockUpdate\Setup;

use DivideByZero\AutoStockUpdate\Model\Connection;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\DB\Ddl\Table;

/**
 * Class UpgradeSchema
 *
 * @package DivideByZero\OrderStatus\Setup
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * Upgrades DB schema for a module
     *
     * @param SchemaSetupInterface   $setup
     * @param ModuleContextInterface $context
     *
     * @return void
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '1.0.1', '<')) {
            $this->createConnectionDetailsTable($setup);
        }
    }

    /**
     * @param SchemaSetupInterface $setup
     */
    private function createConnectionDetailsTable(SchemaSetupInterface $setup): void
    {
        if (!$setup->tableExists($setup->getConnection()->getTableName(Connection::TABLE_NAME))) {
            try {
                $table = $setup->getConnection()->newTable(Connection::TABLE_NAME);
                $table
                    ->addColumn(
                    Connection::ID,
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'ID'
                    )
                    ->addColumn(
                        Connection::NAME,
                        Table::TYPE_TEXT,
                        null,
                        [
                            'nullable' => false,
                            'size' => 255
                        ],
                        'Name'
                    )
                    ->addColumn(
                        Connection::IS_ACTIVE,
                        Table::TYPE_SMALLINT,
                        null,
                        [
                            'nullable' => false,
                        ],
                        'Is Active'
                    )
                    ->addColumn(
                        Connection::USERNAME,
                        Table::TYPE_TEXT,
                        null,
                        [
                            'nullable' => false,
                            'size' => 255
                        ],
                        'Username'
                    )
                    ->addColumn(
                        Connection::PASSWORD,
                        Table::TYPE_TEXT,
                        null,
                        [
                            'nullable' => false,
                            'size' => 255
                        ],
                        'Password'
                    )->addColumn(
                        Connection::HOST,
                        Table::TYPE_TEXT,
                        null,
                        [
                            'nullable' => false,
                            'size' => 50
                        ],
                        'Host'
                    )->addColumn(
                        Connection::PORT,
                        Table::TYPE_TEXT,
                        null,
                        [
                            'nullable' => true,
                            'size' => 50
                        ],
                        'Port'
                    )->addColumn(
                        Connection::STOCK_FILE_DIRECTORY,
                        Table::TYPE_TEXT,
                        null,
                        [
                            'nullable' => true,
                            'size' => 1000
                        ],
                        'Stock File Directory'
                    )->addColumn(
                        Connection::ARCHIVE_FILE_DIRERCTORY,
                        Table::TYPE_TEXT,
                        null,
                        [
                            'nullable' => true,
                            'size' => 1000
                        ],
                        'Archive File Directory'
                    );

                $setup->getConnection()->createTable($table);
            } catch (\Zend_Db_Exception $e) {
            }
        }
    }
}
