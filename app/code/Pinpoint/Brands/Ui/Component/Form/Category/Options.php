<?php

namespace Pinpoint\Brands\Ui\Component\Form\Category;

use Magento\Eav\Model\Config;
use Magento\Eav\Model\Entity\Attribute;
use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\Exception\LocalizedException;

class Options implements OptionSourceInterface
{
    /**
     * @var $eavConfig Config
     */
    protected $eavConfig;

    public function __construct(
        Config $eavConfig
    ) {
        $this->eavConfig = $eavConfig;
    }

    /**
     * @throws LocalizedException
     */
    public function toOptionArray()
    {
        /**
         * @var $attribute Attribute
         */
        $attribute = $this->eavConfig->getAttribute('brand_entity', 'brand_category');
        return $attribute->getSource()->getAllOptions();
    }
}
