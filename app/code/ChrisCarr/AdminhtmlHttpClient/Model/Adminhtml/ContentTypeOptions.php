<?php

namespace ChrisCarr\AdminhtmlHttpClient\Model\Adminhtml;

use Magento\Framework\Data\OptionSourceInterface;

class ContentTypeOptions implements OptionSourceInterface
{

    public function toOptionArray()
    {
        return [
            [
                "label" => "application/json",
                "value" => 0
            ],
            [
                "label" => "application/xml",
                "value" => 1
            ]
        ];
    }
}
