<?php

namespace Pinpoint\Brands\Model;

use Exception;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteriaInterfaceFactory;
use Magento\Framework\EntityManager\EntityManager;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Pinpoint\Brands\Api\BrandRepositoryInterface;
use Pinpoint\Brands\Api\Collection;
use Pinpoint\Brands\Api\Data\BrandInterface;
use Pinpoint\Brands\Api\Data\BrandSearchResultInterfaceFactory;
use Pinpoint\Brands\Model\BrandFactory;
use Pinpoint\Brands\Model\ResourceModel\Brand\CollectionFactory;

class BrandRepository implements BrandRepositoryInterface
{
    /**
     * @var EntityManager
     */
    protected $entityManager;
    /**
     * @var BrandFactory
     */
    private $brandFactory;
    /**
     * @var BrandCollectionFactory
     */
    private $brandCollectionFactory;
    /**
     * @var BrandSearchResultInterfaceFactory
     */
    private $brandSearchResultInterfaceFactory;
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var ImageUploader
     */
    private $imageUploader;

    public function __construct(
        EntityManager                     $entityManager,
        BrandFactory                      $brandFactory,
        CollectionFactory                 $brandCollectionFactory,
        BrandSearchResultInterfaceFactory $brandSearchResultInterfaceFactory,
        CollectionProcessorInterface      $collectionProcessor,
        ImageUploader                     $imageUploader
    ) {
        $this->brandFactory = $brandFactory;
        $this->brandCollectionFactory = $brandCollectionFactory;
        $this->brandSearchResultInterfaceFactory = $brandSearchResultInterfaceFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->entityManager = $entityManager;
        $this->imageUploader = $imageUploader;
    }

    /**
     * @throws NoSuchEntityException
     * @throws LocalizedException
     * @throws Exception
     */
    public function update($brand)
    {
        $oldBrand = $this->getByEntityId($brand->getEntityId());

        $oldData = $oldBrand->getData();
        $newData = $brand->getData();

        foreach ($newData as $k => $v) {
            if ($k == "desktop_image" || $k == "mobile_image") {
                //update img
                //check for new image and pull from tmp if new image
                $v2 = $v[0]["name"];
                if ($oldData[$k] != $v2) {
                    $this->imageUploader->moveFileFromTmp($v2);

                    $img_uri = $this->imageUploader->getFilePath(
                        $this->imageUploader->getBasePath(),
                        $v2
                    );
                    $oldBrand->setData($k, $img_uri);
                }
            } else {
                //update others
                if (isset($oldData[$k]) && $oldData[$k] != $v) {
                    $oldBrand->setData($k, $v);

                }
            }
        }

        $this->entityManager->save($oldBrand);
    }

    /**
     * @throws NoSuchEntityException
     */
    public function getByEntityId($id)
    {
        if (is_numeric($id)) {
            $brand = $this->brandFactory->create();
            $brand = $this->entityManager->load($brand, $id);
            if (!$brand->getTitle()) {
                throw new NoSuchEntityException(__(sprintf("Cannot find brand with id %i", $id)));
            }
            return $brand;
        }
    }

    /**
     * @throws Exception
     */
    public function save(BrandInterface $brand)
    {
        if ($brand["desktop_image"]) {

            $this->imageUploader->moveFileFromTmp($brand["desktop_image"][0]['name']);

            $img_uri = $this->imageUploader->getFilePath(
                $this->imageUploader->getBasePath(),
                $brand["desktop_image"][0]['name']
            );

            $brand['desktop_image'] = $img_uri;
        }

        if ($brand["mobile_image"]) {
            $this->imageUploader->moveFileFromTmp($brand["mobile_image"][0]['name']);

            $img_uri = $this->imageUploader->getFilePath(
                $this->imageUploader->getBasePath(),
                $brand["mobile_image"][0]['name']
            );

            $brand['mobile_image'] = $img_uri;
        }

        $this->entityManager->save($brand);
        return $brand;
    }

    /**
     * @throws Exception
     */
    public function delete(BrandInterface $brand)
    {
        $this->entityManager->delete($brand);
    }

    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->brandCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->brandSearchResultInterfaceFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        return $searchResults;
    }

    public function create()
    {
        return $this->brandFactory->create();
    }

    public function getUnfilteredList()
    {
        $collection = $this->brandCollectionFactory->create();
        return $collection;
    }
}
