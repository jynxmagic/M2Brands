<?php

namespace Pinpoint\Brands\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        if (version_compare($context->getVersion(), '2.0.5', '<')) {
            $installer->getConnection()->addColumn(
                $installer->getTable('brand_entity'),
                'desktop_image',
                [
                    'type' => Table::TYPE_TEXT,
                    'nullable' => false,
                    'length' => 255,
                    'comment' => 'uri to image path'
                ]
            );
        }

        if (version_compare($context->getVersion(), ".2.0.6", '<')) {
            $installer->getConnection()->addColumn(
                $installer->getTable("brand_entity"),
                "mobile_image",
                [
                    'type' => Table::TYPE_TEXT,
                    'nullable' => true,
                    'length' => 255,
                    'comment' => 'uri to mobile image path'
                ]
            );
            $installer->getConnection()->addColumn(
                $installer->getTable("brand_entity"),
                "alt_text",
                [
                    'type' => Table::TYPE_TEXT,
                    'nullable' => true,
                    'length' => 255,
                    'comment' => 'alt text for screenreaders'
                ]
            );
            $installer->getConnection()->addColumn(
                $installer->getTable("brand_entity"),
                "description",
                [
                    "type" => Table::TYPE_TEXT,
                    'nullable' => true,
                    'length' => 255,
                    'comment' => 'description of company'
                ]
            );
            $installer->getConnection()->addColumn(
                $installer->getTable("brand_entity"),
                "enabled",
                [
                    "type" => Table::TYPE_BOOLEAN,
                    'nullable' => false,
                    "default" => true,
                    'comment' => 'is logo enabled?'
                ]
            );
        }

        $installer->endSetup();
    }
}
