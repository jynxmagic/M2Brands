<?php

namespace Pinpoint\Brands\Model\Brand;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Magento\Ui\DataProvider\ModifierPoolDataProvider;
use Pinpoint\Brands\Api\BrandRepositoryInterface;
use Pinpoint\Brands\Api\Data\BrandInterface;
use Pinpoint\Brands\Model\BrandFactory;
use Pinpoint\Brands\Model\ResourceModel\Brand\CollectionFactory;
use Psr\Log\LoggerInterface;

class DataProvider extends ModifierPoolDataProvider
{
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

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $brandCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null,
        ?RequestInterface $request = null,
        ?BrandRepositoryInterface $brandRepository = null,
        ?BrandFactory $brandFactory = null
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
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

        $brand = $this->getCurrentBrand();
        $this->loadedData[$brand->getId()] = $brand->getData();

        return $this->loadedData;
    }

    /**
     * Return current page
     *
     * @return BrandInterface
     */
    private function getCurrentBrand(): BrandInterface
    {
        $brandId = $this->getBrandId();
        if ($brandId) {
            $brand = $this->brandRepository->getById($brandId);

            return $brand;
        }

        $data = $this->dataPersistor->get('brand');
        if (empty($data)) {
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
    private function getBrandId(): int
    {
        return (int)$this->request->getParam($this->getRequestFieldName());
    }

    /**
     * @inheritDoc
     */
    public function getMeta()
    {
        $meta = parent::getMeta();

        return $meta;
    }
}
