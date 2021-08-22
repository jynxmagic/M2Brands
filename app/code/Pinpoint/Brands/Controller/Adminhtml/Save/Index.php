<?php

namespace Pinpoint\Brands\Controller\Adminhtml\Save;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Backend\Model\View\Result\RedirectFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Pinpoint\Brands\Api\BrandRepositoryInterface;

class Index extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Pinpoint_Brands::manage';

    /**
     * @var BrandRepositoryInterface $brandRepository
     */
    protected $brandRepository;


    /**
     * @var RedirectFactory $redirectFactory
     */
    protected $redirectFactory;


    public function __construct(
        Context                  $context,
        BrandRepositoryInterface $brandRepository,
        RedirectFactory          $redirectFactory
    ) {
        parent::__construct($context);
        $this->brandRepository = $brandRepository;
        $this->redirectFactory = $redirectFactory;
    }

    /**
     * Execute action based on request and return result
     *
     * @return ResultInterface|ResponseInterface
     */
    public function execute()
    {
        /**
         * @var Redirect
         */
        $result = $this->redirectFactory->create();

        try {
            $brand = $this->brandRepository->create();
            $data = $this->getRequest()->getParams();
            $brand->setData($data);
            $this->brandRepository->save($brand);
            $this->messageManager->addSuccessMessage(__('Brand saved successfully.'));
            $result->setPath("managelogos/view");
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage(__("Failed to save logo. " . $e->getMessage()));
            $result->setPath("managelogos/edit", ["entity_id" => $this->getRequest()->getParam('entity_id')]);
        }

        return $result;
    }
}
