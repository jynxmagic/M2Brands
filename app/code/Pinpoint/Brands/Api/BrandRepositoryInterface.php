<?php

namespace Pinpoint\Brands\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Pinpoint\Brands\Api\Data\BrandInterface;
use Pinpoint\Brands\Api\Data\BrandSearchResultInterface;

interface BrandRepositoryInterface
{
    /**
     * @param int $id
     * @return BrandInterface
     */
    public function getById($id);

    /**
     * @param BrandInterface $brand
     * @return BrandInterface
     */
    public function save(BrandInterface $brand);

    /**
     * @param BrandInterface $brand
     * @return void
     */
    public function delete(BrandInterface $brand);

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return BrandSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}
