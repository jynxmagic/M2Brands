<?php

namespace Pinpoint\Brands\Setup\Patch\Data;

use Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Model\Entity\Attribute\Source\Table;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Pinpoint\Brands\Model\ResourceModel\Brand;
use Zend_Validate_Exception;

class CategoryPatch implements PatchRevertableInterface, DataPatchInterface
{

    private const BRAND_TABLE = "brand_entity";
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

    /**
     * @throws Zend_Validate_Exception
     * @throws LocalizedException
     */
    public function apply()
    {
        $this->moduleDataSetup->startSetup();

        /**
         * @var EavSetup $installer
         */
        $installer = $this->eavSetupFactory->create(["setup" => $this->moduleDataSetup]);

        $staticType = [
            ["type" => "static"]
        ];

        $entities = [
            self::BRAND_TABLE => [
                "entity_model" => Brand::class,
                "table" => self::BRAND_TABLE,
                "attributes" => [
                    "entity_id" => $staticType,
                    "title" => $staticType,
                    "desktop_image" => $staticType,
                    "mobile_image" => $staticType,
                    "description" => $staticType,
                    "enabled" => $staticType
                ]
            ]
        ];

        $installer->installEntities($entities);

        $installer->addAttribute(
            self::BRAND_TABLE,
            "brand_category",
            [
                "type" => "int",
                "backend" => ArrayBackend::class,
                "frontend" => "",
                "label" => "Brand Category",
                "input" => "select",
                "class" => "select",
                "source" => Table::class,
                "global" => ScopedAttributeInterface::SCOPE_GLOBAL,
                "visible" => true,
                "required" => false,
                "user_defined" => true,
                "default" => "",
                'option' => [
                    'values' => [
                        0 => 'Default',
                        1 => "Example Category 1",
                        2 => "Example Category 2"
                    ]
                ],
            ]
        );

        $this->moduleDataSetup->endSetup();
    }


    public function revert()
    {
        $this->moduleDataSetup->startSetup();

        $installer = $this->eavSetupFactory->create(["setup" => $this->moduleDataSetup]);

        $installer->removeAttribute(self::BRAND_TABLE, "brand_category");

        $this->moduleDataSetup->endSetup();
    }
}
