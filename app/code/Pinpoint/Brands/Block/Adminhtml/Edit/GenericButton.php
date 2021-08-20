<?php

namespace Pinpoint\Brands\Block\Adminhtml\Edit;

use Exception;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\UrlInterface;
use Pinpoint\Brands\Api\BrandRepositoryInterface;

class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * Url Builder
     *
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * Registry
     *
     * @var BrandRepositoryInterface
     */
    protected $brandRepository;

    /**
     * Constructor
     *
     * @param Context $context
     * @param BrandRepositoryInterface $brandRepository
     */
    public function __construct(
        Context                  $context,
        BrandRepositoryInterface $brandRepository
    ) {
        $this->urlBuilder = $context->getUrlBuilder();
        $this->context = $context;
        $this->brandRepository = $brandRepository;
    }

    /**
     * Return the current Catalog Rule Id.
     *
     * @return int|null
     */
    public function getBrandId()
    {
        try {
            return $this->brandRepository->getById(
                $this->context->getRequest()->getParam('page_id')
            )->getId();
        } catch (Exception $e) {
        }
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param string $route
     * @param array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->urlBuilder->getUrl($route, $params);
    }

    /**
     * Check where button can be rendered
     *
     * @param string $name
     * @return string
     */
    public function canRender($name)
    {
        return $name;
    }
}
