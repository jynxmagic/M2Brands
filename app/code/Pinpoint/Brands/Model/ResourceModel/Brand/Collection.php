<?php

namespace Pinpoint\Brands\Model\ResourceModel\Brand;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Pinpoint\Brands\Model\Brand;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';
    protected $_eventPrefix = 'pinpoint_brand_collection';
    protected $_eventObject = 'brand_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Brand::class, \Pinpoint\Brands\Model\ResourceModel\Brand::class);
    }
}
