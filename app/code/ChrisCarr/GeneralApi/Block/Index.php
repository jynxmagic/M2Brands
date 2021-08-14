<?php
namespace ChrisCarr\GeneralApi\Block;

use \Magento\Framework\HTTP\Client\Curl;
use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;
use \ChrisCarr\GeneralApi\Helper\Data;

class Index extends Template
{

    protected $curl;

    protected $helper;

    public function __construct(
        Context $context,
        Curl $curl,
        Data $hdata
    ) {
        $this->curl = $curl;
        $this->helper = $hdata;
        parent::__construct($context);
    }

    public function res()
    {
        $this->curl->addHeader(CURLINFO_CONTENT_TYPE, $this->helper->getConfigFor("contentType"));
        $this->curl->addHeader("Content-Length", $this->helper->getConfigFor("contentLength"));
        $this->curl->setOption(CURLOPT_RETURNTRANSFER, $this->helper->getConfigFor("returnTransfer"));
        $this->curl->setOption(CURLOPT_PORT, $this->helper->getConfigFor("port"));
        $this->curl->get($this->helper->getConfigFor("url"));

        $opts = [
            "content-type" => $this->helper->getConfigFor("contentType"),
            "content-length" => $this->helper->getConfigFor("contentLength"),
            "returnTransfer" => $this->helper->getConfigFor("returnTransfer"),
            "port" => $this->helper->getConfigFor("port"),
            "url" => $this->helper->getConfigFor("url")
        ];

        return $opts;
    }
}
