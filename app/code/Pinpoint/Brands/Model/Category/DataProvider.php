<?php

namespace Pinpoint\Brands\Model\Category;

use Magento\Eav\Api\AttributeRepositoryInterface;
use Magento\Eav\Model\Config;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\LocalizedException;
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
        DataPersistorInterface $dataPersistor,
        Config $eavConfig,
        CollectionFactory $attributeCollectionFactory,
        array $meta = [],
        array $data = [],
        ?RequestInterface $request = null,
        ?AttributeRepositoryInterface $attributeRepository = null
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->dataPersistor = $dataPersistor;
        $this->collection = $attributeCollectionFactory->create();
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
     * @throws LocalizedException
     */
    public function getData()
    {
        $attribute = $this->eavConfig->getAttribute('brand_entity', 'brand_category');
        return $attribute->getSource()->getAllOptions();
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
     * @return string
     */
    private function getCurrentCategory()
    {
        return "brand_category";
    }
}
