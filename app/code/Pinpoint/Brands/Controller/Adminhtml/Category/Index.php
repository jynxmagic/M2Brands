<?php

namespace Pinpoint\Brands\Controller\Adminhtml\Category;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Catalog\Model\ResourceModel\Eav\Attribute;
use Magento\Eav\Model\Entity;
use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action implements HttpGetActionInterface
{
    protected $resultPageFactory;
    protected $coreRegistry;
    protected $_entityTypeId;
    protected $eavAttribute;
    protected $entity;

    public function __construct(
        Context                                           $context,
        PageFactory                                       $resultPageFactory,
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
        $this->_entityTypeId = $this->entity->setType("brand_entity")->getTypeId();
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
