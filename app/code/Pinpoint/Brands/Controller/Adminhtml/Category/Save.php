<?php

namespace Pinpoint\Brands\Controller\Adminhtml\Category;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Eav\Api\AttributeOptionManagementInterface;
use Magento\Eav\Api\Data\AttributeOptionLabelInterface;
use Magento\Eav\Model\AttributeRepository;
use Magento\Eav\Model\Entity\Attribute\Option;
use Magento\Eav\Model\Entity\Attribute\OptionFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;

class Save extends Action implements HttpPostActionInterface
{
    protected $_logger;

    protected $_attributeRepository;

    protected $_attributeOptionManagement;

    protected $optionFactory;

    protected $_attributeOptionLabel;

    public function __construct(
        Context                            $context,
        AttributeRepository                $attributeRepository,
        AttributeOptionManagementInterface $attributeOptionManagement,
        AttributeOptionLabelInterface      $attributeOptionLabel,
        OptionFactory                      $optionFactory
    ) {
        parent::__construct($context);
        $this->_attributeRepository = $attributeRepository;
        $this->_attributeOptionManagement = $attributeOptionManagement;
        $this->optionFactory = $optionFactory;
        $this->_attributeOptionLabel = $attributeOptionLabel;
    }

    public function execute()
    {
        $option_label = $this->getRequest()->getParam("brand_category");

        if ($option_label) {
            try {
                $this->addAttributeOption($option_label);
                $this->messageManager->addSuccessMessage("Successfully created new category");
            } catch (InputException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (StateException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }

        $result = $this->resultRedirectFactory->create();
        $result->setPath("managelogos/view/index");
        return $result;
    }

    /**
     * @throws NoSuchEntityException
     * @throws StateException
     * @throws InputException
     */
    protected function addAttributeOption($option_label)
    {
        $attributeId = $this->_attributeRepository->get("brand_entity", "brand_category")->getAttributeId();

        /**
         * @var Option $option
         */
        $option = $this->optionFactory->create();
        $option->setValue($option_label);
        $option->setLabel($option_label);
        $option->setIsDefault(false);
        $this->_attributeOptionManagement->add("brand_entity", $attributeId, $option);
    }
}
