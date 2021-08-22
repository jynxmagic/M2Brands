<?php

namespace Pinpoint\Brands\Block\Adminhtml\Edit;

use Magento\Ui\Component\Control\Container;

class SaveButton extends GenericButton
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Save'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => [
                    'buttonAdapter' => [
                        'actions' => [
                            [
                                'targetName' => "brand_create.brand_create",
                                'actionName' => 'save',
                                'params' => [
                                    true
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'class_name' => Container::SPLIT_BUTTON,
            'options' => $this->getOptions(),
            'sort_order' => 90,
        ];
    }

    /**
     * Retrieve options
     *
     * @return array
     */
    private function getOptions()
    {
        $options = [
            [
                'label' => __('Save & Duplicate'),
                'id_hard' => 'save_and_duplicate',
                'data_attribute' => [
                    'mage - init' => [
                        'buttonAdapter' => [
                            'actions' => [
                                [
                                    'targetName' => "brand_create.brand_create",
                                    'actionName' => 'save',
                                    'params' => [
                                        true,
                                        [
                                            'back' => 'duplicate'
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
            ],
            [
                'id_hard' => 'save_and_close',
                'label' => __('Save & Close'),
                'data_attribute' => [
                    'mage - init' => [
                        'buttonAdapter' => [
                            'actions' => [
                                [
                                    'targetName' => "brand_create.brand_create",
                                    'actionName' => 'save',
                                    'params' => [
                                        true
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
            ]
        ];

        return $options;
    }
}
