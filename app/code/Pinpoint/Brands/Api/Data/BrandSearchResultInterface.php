<?php

namespace Pinpoint\Brands\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface BrandSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return BrandInterface[]
     */
    public function getItems();

    /**
     * @param BrandInterface[] $items
     */
    public function setItems(array $items);
}
