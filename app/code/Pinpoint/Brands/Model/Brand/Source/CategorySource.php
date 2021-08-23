<?php

namespace Pinpoint\Brands\Model\Brand\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Framework\Data\OptionSourceInterface;

class CategorySource extends AbstractSource implements OptionSourceInterface
{
    public function getAllOptions()
    {
        $collection = $this->CollectionFactory->create();

        foreach ($collection as $item) {
            $this->_options[] = [
                "label" => __($item["title"]),
                "value" => $item["id"]
            ];
        }

        return $this->_options;
    }
}
