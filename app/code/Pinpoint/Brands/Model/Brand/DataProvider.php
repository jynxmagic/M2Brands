<?php

namespace Pinpoint\Brands\Model\Brand;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Pinpoint\Brands\Api\BrandRepositoryInterface;
use Pinpoint\Brands\Api\Data\BrandInterface;
use Pinpoint\Brands\Model\BrandFactory;
use Pinpoint\Brands\Model\ResourceModel\Brand\Collection;
use Pinpoint\Brands\Model\ResourceModel\Brand\CollectionFactory;

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
     * @var BrandRepositoryInterface
     */
    private $brandRepository;

    /**
     * @var RequestInterface
     */
    private $request;
    /**
     * @var BrandFactory
     */
    private $brandFactory;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $brandCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = [],
        ?RequestInterface $request = null,
        ?BrandRepositoryInterface $brandRepository = null,
        ?BrandFactory $brandFactory = null
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $brandCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->meta = $this->prepareMeta($this->meta);
        $this->request = $request ?? ObjectManager::getInstance()->get(RequestInterface::class);
        $this->brandRepository = $brandRepository ?? ObjectManager::getInstance()->get(BrandRepositoryInterface::class);
        $this->brandFactory = $brandFactory ?: ObjectManager::getInstance()->get(BrandFactory::class);
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
            $this->loadedData[$block->getId()]["brand"] = $block->getData();
        }

        $data = $this->dataPersistor->get('brand');
        if (!empty($data)) {
            $block = $this->getCollection()->getNewEmptyItem();
            $block->setData($data);
            $this->loadedData[$block->getId()] = $block->getData();
            $this->dataPersistor->clear("brand");
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
     * @return BrandInterface
     */
    private function getCurrentBrand()
    {
        $brandId = $this->getBrandId();
        if ($brandId) {
            $brand = $this->brandRepository->getByEntityId($brandId);
            return $brand;
        }

        $data = $this->dataPersistor->get('brand');
        if (!empty($data)) {
            return $this->brandRepository->create();
        }
        $this->dataPersistor->clear('brand');

        return $this->brandRepository->create()
            ->setData($data);
    }

    /**
     * Returns current brand id from request
     *
     * @return int
     */
    private function getBrandId()
    {
        return (int)$this->request->getParam($this->getRequestFieldName());
    }
}
