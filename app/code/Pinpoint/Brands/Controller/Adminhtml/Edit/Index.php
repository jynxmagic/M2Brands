<?php

namespace Pinpoint\Brands\Controller\Adminhtml\Edit;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Pinpoint\Brands\Api\BrandRepositoryInterface;

class Index extends Action implements HttpGetActionInterface
{
    const MENU_ID = 'Pinpoint_Brands::logomanager';

    /**
     * @var PageFactory $resultPageFactory
     */
    protected $resultPageFactory;

    /**
     * @var BrandRepositoryInterface $brandRepository
     */
    protected $brandRepository;

    /**
     * Index constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context                  $context,
        PageFactory              $resultPageFactory,
        BrandRepositoryInterface $brandRepositoryInterface
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->brandRepository = $brandRepositoryInterface;
    }

    /**
     * @return Page
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('entity_id');

        $brand = $this->brandRepository->getByEntityId($id);

        if (!$brand->getTitle()) {
            $this->messageManager->addErrorMessage(__("Error loading brand information"));
            $result = $this->resultRedirectFactory->create();
            return $result->setPath("/managelogos/index");
        }

        $result = $this->resultPageFactory->create();
        $result->setActiveMenu("managelogos_edit");
        return $result;
    }
}
