<?php

/**
 * @copyright  Copyright (c) 2021 Jhkinfotech  (https://jhkinfotech.com/)
 */

namespace Jhkinfotech\Ticket\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $this->createSupportTiket($setup);
        $this->supportticketreply($setup);
        $this->department($setup);
        $setup->endSetup();
    }

    /**
     * @param SchemaSetupInterface $setup
     */
    private function createSupportTiket($setup)
    {
        /** @var \Magento\Framework\DB\Adapter\AdapterInterface $connection */
        $connection = $setup->getConnection();
        $tableName = 'jhkinfotech_support_ticket';
        if (!$setup->tableExists($tableName)) {
            $table = $connection->newTable($setup->getTable($tableName))
                ->addColumn(
                    'post_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['identity' => true, 'nullable' => false,'primary' => true,'unsigned' => true],
                    'Post ID'
                )
                ->addColumn('title', Table::TYPE_TEXT, 225, ['nullable' => false], 'Title')
                ->addColumn('customer_id', Table::TYPE_TEXT, 225, ['nullable' => false], 'Customer Id')
                ->addColumn('customeremail', Table::TYPE_TEXT, 225, ['nullable' => false], 'Customer Email')
                ->addColumn('store_id', Table::TYPE_TEXT, null, ['default' => '', 'nullable' => false], 'Stores')
                ->addColumn('status', Table::TYPE_TEXT, 225, ['nullable' => false], 'Status')
                ->addColumn('priority', Table::TYPE_TEXT, 225, ['nullable' => false], 'Priority')
                ->addColumn('department', Table::TYPE_TEXT, 225, ['nullable' => false], 'Department')
                ->addColumn('ccrecipients', Table::TYPE_TEXT, 225, ['nullable' => false], 'CC Recipients')
                ->addColumn('productsku', Table::TYPE_TEXT, 225, ['nullable' => false], 'Product sku')
                ->addColumn('message', Table::TYPE_TEXT, 1000, ['nullable' => false], 'Message')
                ->addColumn('image', Table::TYPE_TEXT, 1000, ['nullable' => false], 'image')
                ->addColumn('customername', Table::TYPE_TEXT, 225, ['nullable' => false], 'Customername')
                ->addColumn(
                    'created_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                    'Creation Time'
                )
                ->addColumn(
                    'updated_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
                    'Modification Time'
                )
                ->addColumn('read_status', Table::TYPE_TEXT, 225, ['nullable' => false, 'default' => 'unread'], 'Ticket Read Status')
                ->addIndex(
                    $setup->getIdxName(
                        $setup->getTable('jhkinfotech_support_ticket'),
                        ['title', 'customeremail','status','priority', 'department', 'customername' ],
                        \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
                    ),
                    [ 'title', 'customeremail','status','priority', 'department', 'customername' ],
                    ['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT]
                )
                ->setComment('jhkinfotech_support_ticket');
                $connection->createTable($table);
        }
    }
    
    private function supportticketreply($setup)
    {
        /** @var \Magento\Framework\DB\Adapter\AdapterInterface $connection */
        $connection = $setup->getConnection();
        $tableName = 'jhkinfotech_support_ticket_reply';
        if (!$setup->tableExists($tableName)) {
            $table = $connection->newTable($setup->getTable($tableName))
                ->addColumn(
                    'reply_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['identity' => true, 'nullable' => false,'primary' => true,'unsigned' => true],
                    'Reply ID'
                )
                ->addColumn('answer', Table::TYPE_TEXT, 1000, ['nullable' => false], 'Answer')
                ->addColumn('image', Table::TYPE_TEXT, 1000, ['nullable' => false], 'image')
                ->addColumn(
                    'post_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['nullable' => false, 'unsigned' => true],
                    'Post Id'
                )
                ->addColumn(
                    'created_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                    'Creation Time'
                )
                ->addColumn(
                    'updated_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
                    'Modification Time'
                )
                ->addColumn('answer_user', Table::TYPE_TEXT, 225, ['nullable' => false], 'answer_user')
                ->addColumn('read_status', Table::TYPE_TEXT, 225, ['nullable' => false, 'default' => 'unread'], 'Ticket Read Status')
                ->addForeignKey(
                    $setup->getFkName(
                        'jhkinfotech_support_ticket_reply',
                        'post_id',
                        'jhkinfotech_support_ticket',
                        'post_id'
                    ),
                    'post_id',
                    $setup->getTable('jhkinfotech_support_ticket'),
                    'post_id',
                    Table::ACTION_CASCADE
                )
                ->setComment('jhkinfotech_support_ticket_reply');
                $connection->createTable($table);
        }
    }
    protected function department($setup)
    {
        /** @var \Magento\Framework\DB\Adapter\AdapterInterface $connection */
        $connection = $setup->getConnection();
        $tableName = 'jhkinfotech_support_department';
        if (!$setup->tableExists($tableName)) {
            $table = $connection->newTable($setup->getTable($tableName))
            ->addColumn(
                'department_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'department_id'
            )
                 
            ->addColumn('name', Table::TYPE_TEXT, 255, ['nullable' => false], 'Option Name')
            ->addColumn(
                'created_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                'Creation Time'
            )
            ->addColumn(
                'updated_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                'Update Time'
            )
            ->addIndex(
                $setup->getIdxName(
                    $setup->getTable('jhkinfotech_support_department'),
                    [ 'name'],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                ['name' ],
                ['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT]
            )
            ->setComment('jhkinfotech_support_department');
                $connection->createTable($table);
        }
    }
}
