<?php
/**
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetKindCustomer\Model;

use Exception;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Webjump\PetKindCustomer\Api\Data\PetKindCustomerInterface;
use Webjump\PetKindCustomer\Api\PetKindCustomerSearchResultsInterface;
use Webjump\PetKindCustomer\Api\PetKindCustomerSearchResultsInterfaceFactory;
use Webjump\PetKindCustomer\Api\PetKindCustomerRepositoryInterface;
use Webjump\PetKindCustomer\Api\Data\PetKindCustomerInterfaceFactory;
use Webjump\PetKindCustomer\Model\ResourceModel\PetKindCustomer\Collection;
use Webjump\PetKindCustomer\Model\ResourceModel\PetKindCustomer\CollectionFactory;
use Webjump\PetKindCustomer\Model\ResourceModel\PetKindCustomerResourceModel;

class PetKindCustomerRepository implements PetKindCustomerRepositoryInterface
{

    /**
     * @var PetKindCustomerInterfaceFactory
     */
    private $modelFactory;

    /**
     * @var PetKindCustomerResourceModel
     */
    private $resourceModel;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var PetKindCustomerSearchResultsInterfaceFactory
     */
    private $petKindCustomerSearchResultsFactory;

    /**
     * PetKindCustomerRepository constructor.
     * @param PetKindCustomerInterfaceFactory $modelFactory
     * @param PetKindCustomerResourceModel $resourceModel
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param CollectionFactory $collectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param PetKindCustomerSearchResultsInterfaceFactory $petKindCustomerSearchResultsFactory
     */
    public function __construct(
        PetKindCustomerInterfaceFactory $modelFactory,
        PetKindCustomerResourceModel $resourceModel,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        CollectionFactory $collectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        PetKindCustomerSearchResultsInterfaceFactory $petKindCustomerSearchResultsFactory
    ) {
        $this->modelFactory = $modelFactory;
        $this->resourceModel = $resourceModel;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->collectionFactory = $collectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->petKindCustomerSearchResultsFactory = $petKindCustomerSearchResultsFactory;
    }


    /**
     * @inheritDoc
     */
    public function getById(int $entityId): PetKindCustomerInterface
    {
        /** @var PetKindCustomerInterface $model */
        $model = $this->modelFactory->create();
        $this->resourceModel->load($model, $entityId);
        return $model;
    }

    /**
     * @param int $customerId
     * @return PetKindCustomerInterface
     */
    public function getByCustomerId(int $customerId): PetKindCustomerInterface
    {
        $collection = $this->collectionFactory->create();
        $collection->addFilter(PetKindCustomerInterface::CUSTOMER_ID, $customerId);
        /** @var PetKindCustomerInterface $petKindCustomer */
        $petKindCustomer = $collection->getFirstItem();
        return $petKindCustomer;
    }

    /**
     * @inheritDoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null): PetKindCustomerSearchResultsInterface
    {
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();
        if (null === $searchCriteria) {
            $searchCriteria = $this->searchCriteriaBuilder->create();
        } else {
            $this->collectionProcessor->process($searchCriteria, $collection);
        }

        /** @var PetKindCustomerSearchResultsInterface $searchResult */
        $searchResult = $this->petKindCustomerSearchResultsFactory->create();
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());
        $searchResult->setSearchCriteria($searchCriteria);
        return $searchResult;
    }

    /**
     * @inheritDoc
     */
    public function save(PetKindCustomerInterface $petKindCustomer): int
    {
        try {
            $this->resourceModel->save($petKindCustomer);
            return (int) $petKindCustomer->getEntityId();
        } catch (Exception $e) {
            throw new CouldNotSaveException(__('Could not save relationship between pet kind and customer'), $e);
        }
    }

    public function deleteById(int $entityId): bool
    {
        try {
            $this->resourceModel->delete($this->getById($entityId));
        } catch (Exception $e) {
            throw new CouldNotDeleteException(__('Could not delete relationship between pet kind and customer'), $e);
        }
        return true;
    }

}
