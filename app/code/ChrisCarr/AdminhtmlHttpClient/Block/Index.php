<?php

namespace ChrisCarr\AdminhtmlHttpClient\Block;

use ChrisCarr\AdminhtmlHttpClient\Helper\Data;
use GuzzleHttp\Client;
use GuzzleHttp\ClientFactory;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\ResponseFactory;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Webapi\Request;

class Index extends Template
{
    protected $clientFactory;
    protected $responseFactory;

    protected $helper;

    public function __construct(
        Context         $context,
        Data            $helper,
        ClientFactory   $clientFactory,
        ResponseFactory $responseFactory
    ) {
        $this->clientFactory = $clientFactory;
        $this->responseFactory = $responseFactory;
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

        /**
         * @var Client $client
         */
        $client = $this->clientFactory->create([
            "config" => [
                "base_uri" => $opts["url"]
            ]
        ]);

        try {
            $res = $client->request(
                Request::METHOD_GET,
                '',
                [
                    "headers" => ["Accept-Encoding" => $opts["content-type"]],

                ]
            );
        } catch (GuzzleException $e) {
            $res = $this->responseFactory->create([
                "status" => $e->getCode(),
                "reason" => $e->getMessage()
            ]);
        }

        return $res->getBody();
    }
}
