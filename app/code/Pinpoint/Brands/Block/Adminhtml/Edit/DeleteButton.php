<?php

namespace Pinpoint\Brands\Block\Adminhtml\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\App\Request\Http;
use Magento\Ui\Component\Control\Container;
use Pinpoint\Brands\Api\BrandRepositoryInterface;

class DeleteButton extends GenericButton
{
    /**
     * @var Http $request
     */
    protected $request;

    public function __construct(Context $context, BrandRepositoryInterface $brandRepository, Http $request)
    {
        parent::__construct($context, $brandRepository);
        $this->request = $request;
    }

    /**
     * @return array
     */
    public function getButtonData()
    {
        if (!str_contains($this->request->getFullActionName(), "edit")) {
            return [];
        }
        return [
            'label' => __('Delete'),
            'class' => 'primary delete',
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
            'class_name' => Container::DEFAULT_CONTROL,
            'sort_order' => 90
        ];
    }
}
