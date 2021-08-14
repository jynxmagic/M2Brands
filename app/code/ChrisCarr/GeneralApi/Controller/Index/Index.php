<?php
declare(strict_types=1);

namespace ChrisCarr\GeneralApi\Controller\Index;

use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Action\HttpGetActionInterface;

/**
 * Class Index
 * ChrisCarr\GeneralApi\Controller\Index\Index
 */
class Index implements HttpGetActionInterface
{

    /**
     * Index resultPageFactory
     * @var PageFactory
     */
    protected $resultPageFactory;
    protected $requestInterface;

    /**
     * Index constructor.
     * @param PageFactory $resultPageFactory
     * @param RequestInterface $requestInterface
     */
    public function __construct(PageFactory $resultPageFactory, RequestInterface $requestInterface)
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->requestInterface = $requestInterface;
    }

    /**
     * Function execute
     * @return Page
     */
    public function execute()
    {
        return $this->resultPageFactory->create();
    }
}
