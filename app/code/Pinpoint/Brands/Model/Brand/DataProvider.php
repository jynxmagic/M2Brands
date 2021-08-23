<?php

namespace Pinpoint\Brands\Model\Brand;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Rss\DataProviderInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Pinpoint\Brands\Api\BrandRepositoryInterface;
use Pinpoint\Brands\Api\Data\BrandInterface;
use Pinpoint\Brands\Model\BrandFactory;
use Pinpoint\Brands\Model\ResourceModel\Brand\Collection;
use Pinpoint\Brands\Model\ResourceModel\Brand\CollectionFactory;

class DataProvider extends AbstractDataProvider implements DataProviderInterface
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
    protected $storeManager;
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
        StoreManagerInterface $storeManager,
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
        $this->storeManager = $storeManager;
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
     * @inheritDoc
     */
    public function getMeta()
    {
        $meta = parent::getMeta();

        return $meta;
    }

    public function isAllowed()
    {
        return true;
    }

    public function getRssData()
    {
        return $this->getData();
    }

    /**
     * Get data
     *
     * @return array
     * @throws NoSuchEntityException
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->getCollection()->getItems();

        foreach ($items as $item) {
            $this->loadedData[$item->getId()] = $item->getData();
            $desktopImage = $item->getData("desktop_image");
            $mobileImage = $item->getData("mobile_image");

            if ($desktopImage) {
                $loadedImage = $this->convertImageUriToArray($desktopImage);
                $this->loadedData[$item->getId()]["desktop_image"] = $loadedImage;
            }
            if ($mobileImage) {
                $loadedImage = $this->convertImageUriToArray($mobileImage);
                $this->loadedData[$item->getId()]["mobile_image"] = $loadedImage;
            }
        }

        return $this->loadedData;
    }

    /**
     * @throws NoSuchEntityException
     */
    private function convertImageUriToArray($imageUri)
    {
        $tmp[0]['name'] = $imageUri;
        $tmp[0]['url'] = $this->getImageUrlForImage($imageUri);

        return $tmp;
    }

    /**
     * @throws NoSuchEntityException
     */
    public function getImageUrlForImage($img)
    {
        if ($img == null) {
            return "";
        }
        $mediaUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
        $mediaUrl .= $img;
        return $mediaUrl;
    }

    public function getCacheKey()
    {
        return "category_create_form";
    }

    public function getCacheLifetime()
    {
        return -1;
    }

    public function getFeeds()
    {
        return $this->getData();
    }

    public function isAuthRequired()
    {
        return false;
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
