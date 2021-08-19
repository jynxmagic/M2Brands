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
    const ID = "id";
    protected $_cacheTag = 'pinpoint_brands_brand';
    protected $_eventPrefix = 'pinpoint_brands_brand';

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getId()
    {
        return $this->_getData(self::ID);
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }

    public function setId($id)
    {
        $this->setData(self::ID, $id);
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

    protected function _construct()
    {
        $this->_init(ResourceModel\Brand::class);
    }
}
