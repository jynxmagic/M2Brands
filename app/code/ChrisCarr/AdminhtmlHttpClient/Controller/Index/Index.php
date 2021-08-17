<?php
declare(strict_types=1);

namespace ChrisCarr\AdminhtmlHttpClient\Controller\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\Raw;
use Magento\Framework\Controller\Result\RawFactory;

/**
 * Class Index
 * ChrisCarr\AdminhtmlHttpClient\Controller\Index\Index
 */
class Index implements HttpGetActionInterface
{

    protected $requestInterface;
    /**
     * @var RawFactory
     */
    protected $resultRawFactory;

    protected $block;


    /**
     * Index constructor.
     * @param RawFactory $jsonFactory
     * @param RequestInterface $requestInterface
     */
    public function __construct(
        RawFactory                                 $resultRawFactory,
        RequestInterface                           $requestInterface,
        \ChrisCarr\AdminhtmlHttpClient\Block\Index $block
    ) {
        $this->resultRawFactory = $resultRawFactory;
        $this->requestInterface = $requestInterface;
        $this->block = $block;
    }

    /**
     * Function execute
     * @return Raw
     */
    public function execute()
    {
        $res = $this->resultRawFactory->create();
        $res->setContents($this->block->res());
        return $res;
    }
}
