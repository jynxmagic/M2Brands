<?php

namespace Pinpoint\Brands\Block\Widget;

use Magento\Framework\Api\Filter;
use Magento\Framework\Api\FilterFactory;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Widget\Block\BlockInterface;
use Pinpoint\Brands\Api\BrandRepositoryInterface;

class Logo extends Template implements BlockInterface
{

    protected $brandRepositoryInterface;
    protected $searchCriteriaBuilder;
    protected $filterFactory;
    protected $storeManager;

    /**
     * construct description
     * @param Context $context
     * @param BrandRepositoryInterface $brandRepositoryInterface
     * @param FilterFactory $filterFactory
     * @param [] $data[]
     */
    public function __construct(
        Context                  $context,
        BrandRepositoryInterface $brandRepositoryInterface,
        SearchCriteriaBuilder    $searchCriteriaBuilder,
        FilterFactory            $filterFactory,
        StoreManagerInterface    $storeManager,
        array                    $data = []
    ) {
        parent::__construct($context, $data);
        $this->brandRepositoryInterface = $brandRepositoryInterface;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterFactory = $filterFactory;
        $this->storeManager = $storeManager;
    }

    public function getBrands()
    {
        /**
         * @var Filter $filter
         */
        $filter = $this->filterFactory->create();
        $filter->setField("title");
        $filter->setValue("Mobile image test");
        $this->searchCriteriaBuilder->addFilter($filter);
        $criteria = $this->searchCriteriaBuilder->create();
        $brands = $this->brandRepositoryInterface->getList($criteria)->getItems();

        return $brands;
    }

    /**
     * @throws NoSuchEntityException
     */
    public function getImageUrlForImage($img)
    {
        if ($img == null) {
            return "";
        }
        $mediaUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
        $mediaUrl .= $img;
        return $mediaUrl;
    }

    /**
     * construct function
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('logo_list.phtml');
    }
}
