<?php

namespace Pinpoint\Brands\Setup;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Pinpoint\Brands\Setup\BrandSetupFactory;
use Zend_Validate_Exception;

class InstallData implements InstallDataInterface
{

    /**
     * @var BrandSetupFactory $eavSetupFactory
     */
    protected $brandSetupFactory;


    /**
     * @param BrandSetupFactory $brandSetupFactory
     */
    public function __construct(BrandSetupFactory $brandSetupFactory)
    {
        $this->brandSetupFactory = $brandSetupFactory;
    }

    /**
     * @throws Zend_Validate_Exception
     * @throws LocalizedException
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), "2.0.0") < 0) {
            /**
             * @var BrandSetup $brandSetup
             */
            /*     $brandSetup = $this->brandSetupFactory->create(["setup" => $setup]);

                 $brandSetup->installEntities();

                 $brandSetup->addAttribute(
                     "brand_entity",
                     "desktop_image",
                     [
                         "type" => 'varchar',
                         "label" => "Desktop Image",
                         "input" => "image",
                         'frontend' => Image::class,
                         "backend" => "Pinpoint\Brands\Model\Brand\Attribute\Backend\Image",
                         "required" => true,
                         "sort_order" => 3,
                         "global" => ScopedAttributeInterface::SCOPE_STORE
                     ]
                 ); */
        }

        $setup->endSetup();
    }
}
