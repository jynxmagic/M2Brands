<?php

namespace Pinpoint\Brands\Setup\Patch\Data;

use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Model\Entity\Attribute\Source\Table;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;

class CategoryPatch implements PatchRevertableInterface, DataPatchInterface
{

    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var EavSetup
     */
    private $eavSetupFactory;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory          $eavSetupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    public static function getDependencies()
    {
        return [];
    }

    public static function getVersion()
    {
        return "2.0.8";
    }

    public function getAliases()
    {
        return [
        ];
    }

    public function apply()
    {
        $this->moduleDataSetup->startSetup();

        $installer = $this->eavSetupFactory->create(["setup" => $this->moduleDataSetup]);

        $installer->addAttribute(
            Product::ENTITY,
            "brand_category",
            [
                "type" => "int",
                "backend" => "",
                "frontend" => "",
                "label" => "Brand Category",
                "input" => "select",
                "class" => "",
                "source" => Table::class,
                "global" => ScopedAttributeInterface::SCOPE_GLOBAL,
                "visible" => true,
                "required" => false,
                "default" => ""
            ]
        );

        $this->moduleDataSetup->endSetup();
    }

    public function revert()
    {
        $this->moduleDataSetup->startSetup();

        $installer = $this->eavSetupFactory->create(["setup" => $this->moduleDataSetup]);

        $installer->removeAttribute(Product::ENTITY, "brand_category");

        $this->moduleDataSetup->endSetup();
    }
}
