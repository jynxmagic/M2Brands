<?php

namespace Pinpoint\Brands\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Pinpoint\Brands\Api\Data\BrandExtensionInterface;
use Pinpoint\Brands\Api\Data\BrandInterface;

class Brand extends AbstractModel implements BrandInterface, IdentityInterface
{
    const CACHE_TAG = 'pinpoint_brands_brand';
    const TITLE = "title";
    protected $_cacheTag = 'pinpoint_brands_brand';
    protected $_eventPrefix = 'pinpoint_brands_brand';

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getEntityId()
    {
        return $this->getData("entity_id");
    }

    public function setEntityId($data)
    {
        $this->setData("entity_id", $data);
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }

    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    public function setTitle($title)
    {
        $this->setData(self::TITLE, $title);
    }

    public function getExtensionAttributes()
    {
        return $this->getExtensionAttributes();
    }

    public function setExtensionAttributes(BrandExtensionInterface $extensionAttributes)
    {
        $this->setExtensionAttributes($extensionAttributes);
    }

    public function getDescription()
    {
        return $this->getData("description");
    }

    public function setDescription($data)
    {
        $this->setData("description", $data);
    }

    public function getAltText()
    {
        return $this->getData("alt_text");
    }

    public function setAltText($data)
    {
        $this->setData("alt_text", $data);
    }

    public function getDesktopImage()
    {
        return $this->getData("desktop_image");
    }

    public function setDesktopImage($data)
    {
        $this->setData("desktop_image", $data);
    }

    public function getMobileImage()
    {
        return $this->getData("mobile_image");
    }

    public function setMobileImage($data)
    {
        $this->setData("mobile_image", $data);
    }

    public function setEnabled($data)
    {
        $this->setData("enabled", $data);
    }

    public function getEnabled()
    {
        return $this->getData("enabled");
    }

    public function getBrandCategoryOptionId()
    {
        return $this->getData("brand_category_option_id");
    }

    public function setBrandCategoryOptionId($data)
    {
        $this->setData("brand_category_option_id", $data);
    }

    protected function _construct()
    {
        $this->_init(ResourceModel\Brand::class);
    }
}
