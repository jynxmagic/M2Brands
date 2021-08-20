<?php

namespace Pinpoint\Brands\Controller\Adminhtml\Save;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Pinpoint\Brands\Api\BrandRepositoryInterface;

class Index extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Pinpoint_Brands::manage';
    private $brandRepository;

    public function __construct(
        Context                  $context,
        BrandRepositoryInterface $brandRepository
    ) {
        parent::__construct($context);
        $this->brandRepository = $brandRepository;
    }

    /**
     * Execute action based on request and return result
     *
     * @return ResultInterface|ResponseInterface
     */
    public function execute()
    {
        $brand = $this->brandRepository->create();
        $data = $this->getRequest()->getParams();
        $brand->setData($data);

        $this->brandRepository->save($brand);
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
