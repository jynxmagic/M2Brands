<?php

namespace Pinpoint\Brands\Block\Widget\Source;

use Magento\Eav\Model\Config;
use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\Exception\LocalizedException;

class Select implements OptionSourceInterface
{
    /**
     * @var Config $eavConfig
     */
    protected $eavConfig;

    public function __construct(Config $eavConfig)
    {
        $this->eavConfig = $eavConfig;
    }

    /**
     * @throws LocalizedException
     */
    public function toOptionArray()
    {
        $options = $this->eavConfig->getAttribute("brand_entity", "brand_category")->getSource()->getAllOptions();

        return $options;
    }
}
