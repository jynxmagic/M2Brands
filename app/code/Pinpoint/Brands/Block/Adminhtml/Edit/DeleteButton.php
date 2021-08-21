<?php

namespace Pinpoint\Brands\Block\Adminhtml\Edit;

use Magento\Ui\Component\Control\Container;

class DeleteButton extends GenericButton
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Delete'),
            'class' => 'delete',
            'data_attribute' => [
                'mage-init' => [
                    'buttonAdapter' => [
                        'actions' => [
                            [
                                'targetName' => "brand_create.brand_create",
                                'actionName' => 'delete',
                                'params' => [
                                    true
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'class_name' => Container::SPLIT_BUTTON,
            'options' => [],
            'sort_order' => 90,
        ];
    }
}
