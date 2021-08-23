<?php

namespace Pinpoint\Brands\Model\Category;

use Magento\Eav\Api\AttributeRepositoryInterface;
use Magento\Eav\Api\Data\AttributeInterface;
use Magento\Eav\Model\Config;
use Magento\Eav\Model\ResourceModel\Attribute\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{
    /**
     * @var Collection
     */
    protected $collection;
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @var AttributeRepositoryInterface $attributeRepository
     */
    private $attributeRepository;

    /**
     * @var RequestInterface
     */
    private $request;
    /**
     * @var Config $eavConfig
     */
    private $eavConfig;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $attributeCollectionFactory,
        DataPersistorInterface $dataPersistor,
        Config $eavConfig,
        array $meta = [],
        array $data = [],
        ?RequestInterface $request = null,
        ?AttributeRepositoryInterface $attributeRepository = null
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $attributeCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->meta = $this->prepareMeta($this->meta);
        $this->request = $request;
        $this->attributeRepository = $attributeRepository;
        $this->eavConfig = $eavConfig;
    }

    /**
     * Prepares Meta
     *
     * @param array $meta
     * @return array
     */
    public function prepareMeta(array $meta)
    {
        return $meta;
    }


    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->getCollection()->getItems();

        foreach ($items as $block) {
            $this->loadedData[$block->getId()]["brand_category"] = $block->getData();
        }

        $data = $this->dataPersistor->get('brand_category');
        if (!empty($data)) {
            $block = $this->getCollection()->getNewEmptyItem();
            $block->setData($data);
            $this->loadedData[$block->getId()] = $block->getData();
            $this->dataPersistor->clear("brand_category");
        }

        return $this->loadedData;
    }

    /**
     * @inheritDoc
     */
    public function getMeta()
    {
        $meta = parent::getMeta();

        return $meta;
    }

    /**
     * Return current page
     *
     * @return AttributeInterface
     */
    private function getCurrentCategory()
    {
        return $this->$this->attributeRepository->get("brand_entity", "brand_category");
    }
}
