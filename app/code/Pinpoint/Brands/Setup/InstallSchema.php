<?php

namespace Pinpoint\Brands\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * Function install
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        $table = $installer->getConnection()->newTable(
            $installer->getTable("brand_entity")
        );

        $table->addColumn(
            "id",
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true,]
        );

        $table->addColumn(
            "title",
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            "Brand Title"
        );

        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}
