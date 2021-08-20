<?php

namespace Pinpoint\Brands\Setup;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Zend_Db_Exception;

class InstallSchema implements InstallSchemaInterface
{


    /**
     * Function install
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     * @throws Zend_Db_Exception
     */
    public function install(
        SchemaSetupInterface   $setup,
        ModuleContextInterface $context
    ) {
        $installer = $setup;

        if (version_compare($context->getVersion(), '2.0.0') < 0) {

            $installer->startSetup();

            $table = $installer->getConnection()->newTable(
                $installer->getTable("brand_entity")
            );

            $table->addColumn(
                "entity_id",
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                "Entity ID"
            );

            $table->addColumn(
                "id",
                Table::TYPE_INTEGER,
                null
            );

            $table->addColumn(
                "title",
                Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                "Brand Title"
            );
            $table->addColumn(
                "desktop_image",
                Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                "Desktop Image"
            );

            $installer->getConnection()->createTable($table);

            $installer->endSetup();
        }
    }
}
