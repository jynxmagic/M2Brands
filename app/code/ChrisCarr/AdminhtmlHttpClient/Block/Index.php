<?php

namespace ChrisCarr\AdminhtmlHttpClient\Block;

use ChrisCarr\AdminhtmlHttpClient\Helper\Data;
use Magento\Framework\HTTP\Client\Curl;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Index extends Template
{

    protected $curl;
    protected $helper;


    public function __construct(
        Context $context,
        Curl    $curl,
        Data    $helper
    ) {
        $this->curl = $curl;
        $this->helper = $helper;
        parent::__construct($context);
    }

    public function res()
    {
        $opts = [
            "content-type" => $this->helper->getConfigFor("contentType"),
            "content-length" => $this->helper->getConfigFor("contentLength"),
            "returnTransfer" => $this->helper->getConfigFor("returnTransfer"),
            "port" => $this->helper->getConfigFor("port"),
            "url" => $this->helper->getConfigFor("url")
        ];

        $this->curl->setOption(CURLOPT_ACCEPT_ENCODING, $opts["content-type"]);
        $this->curl->setOption(CURLOPT_RETURNTRANSFER, $opts["returnTransfer"]);
        $this->curl->setOption(CURLOPT_PORT, $opts["port"]);
        $this->curl->setOption(CURLOPT_TIMEOUT, 30);
        $this->curl->setOption(CURLOPT_FOLLOWLOCATION, false);
        $this->curl->get($opts["url"]);

        return $this->curl->getBody();
    }

    public function tests()
    {
        return __("big tests");
    }
}
