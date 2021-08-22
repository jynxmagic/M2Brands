<?php

namespace Pinpoint\Brands\Controller\Adminhtml\Delete;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Pinpoint\Brands\Api\BrandRepositoryInterface;

class Index extends Action implements HttpPostActionInterface
{
    /**
     * @var BrandRepositoryInterface $brandRepository
     */
    protected $brandRepository;

    /**
     * @param Context $context
     * @param BrandRepositoryInterface $brandRepository
     */
    public function __construct(Context $context, BrandRepositoryInterface $brandRepository)
    {
        parent::__construct($context);
        $this->brandRepository = $brandRepository;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam("entity_id");
        $result = $this->resultRedirectFactory->create();
        try {
            $brand = $this->brandRepository->getByEntityId($id);
            $this->brandRepository->delete($brand);
            $this->messageManager->addSuccessMessage(__($brand->getTitle() . " brand deleted."));
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage(__("failed to delete " . $brand->getTitle() . " entity. " . $e->getMessage()));
        }
        return $this->_redirect("managelogos/view/index");
    }
}
