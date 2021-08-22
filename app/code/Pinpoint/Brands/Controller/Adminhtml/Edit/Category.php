<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Catalog\Controller\Adminhtml\Product\Attribute;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Catalog\Model\ResourceModel\Eav\Attribute;
use Magento\Eav\Model\Entity;
use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\ResultPageFactory;
use Pinpoint\Brands\Model\Brand;

class Category extends Action implements HttpGetActionInterface
{
    protected $resultPageFactory;
    protected $coreRegistry;
    protected $_entityTypeId;
    protected $eavAttribute;
    protected $entity;

    public function __construct(
        Context                                           $context,
        ResultPageFactory                                 $resultPageFactory,
        Registry                                          $coreRegistry,
        Entity                                            $entity,
        \Magento\Eav\Model\ResourceModel\Entity\Attribute $eavAttribute
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->coreRegistry = $coreRegistry;
        $this->entity = $entity;
        $this->eavAttribute = $eavAttribute;
    }

    public function dispatch(RequestInterface $request)
    {
        $this->_entityTypeId = $this->entity->setType(Brand::class)->getTypeId();
        return parent::dispatch($request);
    }

    /**
     * @return ResultInterface
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $id = $this->eavAttribute->getIdByCode("brand_entity", "brand_category");

        /** @var $attribute Attribute */
        $attribute = $this->eavAttribute->getEntityAttribute($id);

        $attributeData = $this->getRequest()->getParam('attribute');
        if (!empty($attributeData) && $id === null) {
            $attribute->addData($attributeData);
        }
        $this->coreRegistry->register("brand_entity", $attribute);

        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Edit Brand Category Attribute'));
        return $resultPage;
    }
}
