<?php
namespace ChrisCarr\GeneralApi\Block;

use Magento\Framework\HTTP\Client\Curl;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use ChrisCarr\GeneralApi\Helper\Data;

class Index extends Template
{
    protected $_curl;

    protected $_helper;

    public function __construct(Context $context, Curl $curl, Data $data)
    {
        parent::__construct($context);
        $this->_curl = $curl;
        $this->_helper = $data;
    }

    public function res()
    {
        $this->_curl->addHeader(CURLINFO_CONTENT_TYPE, $this->_helper->getConfigFor("content-type"));
        $this->_curl->addHeader("Content-Length", $this->_helper->getConfigFor("content-length"));
        $this->_curl->setOption(CURLOPT_RETURNTRANSFER, $this->_helper->getConfigFor("return-transfer"));
        $this->_curl->setOption(CURLOPT_PORT, $this->_helper->getConfigFor("port"));
        $this->_curl->get($this->_helper->getConfigFor("url"));
        return $this->_curl->getBody();
    }
}
