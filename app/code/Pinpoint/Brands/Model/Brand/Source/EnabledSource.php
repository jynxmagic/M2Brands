<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Pinpoint\Brands\Model\Brand\Source;

use Magento\Cms\Model\Block;
use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class EnabledSource
 */
class EnabledSource implements OptionSourceInterface
{
    /**
     * @var Block
     */
    protected $cmsBlock;

    /**
     * Constructor
     *
     * @param Block $cmsBlock
     */
    public function __construct(Block $cmsBlock)
    {
        $this->cmsBlock = $cmsBlock;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $availableOptions = $this->cmsBlock->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
