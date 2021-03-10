<?php

namespace Vikhyat\Department\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     *
     * @return void
     */
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $setup->startSetup();
        $this->department($setup);       
        $setup->endSetup();
    }

    /**
     * @param SchemaSetupInterface $setup
     */
    protected function department(SchemaSetupInterface $installer)
    {
        $table  = $installer->getConnection()
        ->newTable($installer->getTable('vikhyat_department'))
            ->addColumn(
                'department_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'department_id'
            )
                 
            ->addColumn('name', Table::TYPE_TEXT, 255,['nullable' => false],'Option Name')
            ->addColumn('creation_time',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],'Creation Time'
            ) 
            ->addColumn('update_time',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],'Update Time'
            );                    
        $installer->getConnection()->createTable($table);
    }
}

  