<?php

namespace Pinpoint\Brands\Block\Adminhtml\Edit;

use Exception;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Pinpoint\Brands\Api\BrandRepositoryInterface;
use Pinpoint\Brands\Model\Brand;

class GenericButton implements ButtonProviderInterface
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
        BrandRepositoryInterface $brandRepository,
        $formName
    ) {
        $this->urlBuilder = $context->getUrlBuilder();
        $this->context = $context;
        $this->brandRepository = $brandRepository;
        $this->formName = $formName;
    }

    /**
     * Return the current brand
     *
     * @return Brand|null
     */
    public function getBrand()
    {
        try {
            return $this->brandRepository->getByEntityId(
                $this->context->getRequest()->getParam('entity_id')
            );
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

    public function getButtonData()
    {
        return [];
    }
}
