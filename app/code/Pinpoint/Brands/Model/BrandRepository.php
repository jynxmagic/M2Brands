<?php

namespace Pinpoint\Brands\Model;

use Exception;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteriaInterfaceFactory;
use Magento\Framework\EntityManager\EntityManager;
use Magento\Framework\Exception\NoSuchEntityException;
use Pinpoint\Brands\Api\BrandRepositoryInterface;
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

    public function __construct(
        EntityManager                     $entityManager,
        BrandFactory                      $brandFactory,
        CollectionFactory                 $brandCollectionFactory,
        BrandSearchResultInterfaceFactory $brandSearchResultInterfaceFactory,
        CollectionProcessorInterface      $collectionProcessor
    ) {
        $this->brandFactory = $brandFactory;
        $this->brandCollectionFactory = $brandCollectionFactory;
        $this->brandSearchResultInterfaceFactory = $brandSearchResultInterfaceFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->entityManager = $entityManager;
    }

    /**
     * @throws NoSuchEntityException
     */
    public function getById($id)
    {
        if (is_numeric($id)) {
            $brand = $this->brandFactory->create();
            $brand = $this->entityManager->load($brand, $id);
            if (!$brand->getId()) {
                throw new NoSuchEntityException(__(sprintf("Cannot find brand with id %i", $id)));
            }
            return $brand;
        }
        throw new NoSuchEntityException(__(sprintf("Brand id must be numeric. `%s` given.", $id)));
    }

    /**
     * @throws Exception
     */
    public function save(BrandInterface $brand)
    {
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
}
