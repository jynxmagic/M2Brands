<?php

namespace ChrisCarr\GeneralApi\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    const XML_PATH_CONFIG = 'generalapiconfig/generalgroup/';

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        Context $context
    ) {
        parent::__construct($context);
        $this->scopeConfig = $scopeConfig;
    }

    public function getConfigFor($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_CONFIG . $field,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}
