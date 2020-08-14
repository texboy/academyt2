<?php
/**
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetKind\Model;

use Exception;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Webjump\PetKind\Api\Data\PetKindInterface;
use Webjump\PetKind\Api\PetKindSearchResultsInterface;
use Webjump\PetKind\Api\PetKindSearchResultsInterfaceFactory;
use Webjump\PetKind\Api\PetKindRepositoryInterface;
use Webjump\PetKind\Api\Data\PetKindInterfaceFactory;
use Webjump\PetKind\Model\ResourceModel\PetKind\Collection;
use Webjump\PetKind\Model\ResourceModel\PetKind\CollectionFactory;
use Webjump\PetKind\Model\ResourceModel\PetKindResourceModel;

class PetKindRepository implements PetKindRepositoryInterface
{

    /**
     * @var PetKindInterfaceFactory
     */
    private $modelFactory;

    /**
     * @var PetKindResourceModel
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
     * @var PetKindSearchResultsInterfaceFactory
     */
    private $petKindSearchResultsFactory;

    /**
     * PetKindRepository constructor.
     * @param PetKindInterfaceFactory $modelFactory
     * @param PetKindResourceModel $resourceModel
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param CollectionFactory $collectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param PetKindSearchResultsInterfaceFactory $petKindSearchResultsFactory
     */
    public function __construct(
        PetKindInterfaceFactory $modelFactory,
        PetKindResourceModel $resourceModel,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        CollectionFactory $collectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        PetKindSearchResultsInterfaceFactory $petKindSearchResultsFactory
    ) {
        $this->modelFactory = $modelFactory;
        $this->resourceModel = $resourceModel;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->collectionFactory = $collectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->petKindSearchResultsFactory = $petKindSearchResultsFactory;
    }


    /**
     * @inheritDoc
     */
    public function getById(int $entityId): PetKindInterface
    {
        /** @var PetKindInterface $model */
        $model = $this->modelFactory->create();
        $this->resourceModel->load($model, $entityId);
        return $model;
    }

    /**
     * @inheritDoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null): PetKindSearchResultsInterface
    {
        /** @var Collection $petTypeCollection */
        $collection = $this->collectionFactory->create();
        if (null === $searchCriteria) {
            $searchCriteria = $this->searchCriteriaBuilder->create();
        } else {
            $this->collectionProcessor->process($searchCriteria, $collection);
        }

        /** @var PetKindSearchResultsInterface $searchResult */
        $searchResult = $this->petKindSearchResultsFactory->create();
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());
        $searchResult->setSearchCriteria($searchCriteria);
        return $searchResult;
    }

    /**
     * @inheritDoc
     */
    public function save(PetKindInterface $petType): int
    {
        try {
            $this->resourceModel->save($petType);
            return (int) $petType->getEntityId();
        } catch (Exception $e) {
            throw new CouldNotSaveException(__('Could not save pet type'), $e);
        }
    }

    public function deleteById(int $entityId): bool
    {
        try {
            $this->resourceModel->delete($this->getById($entityId));
        } catch (Exception $e) {
            throw new CouldNotDeleteException(__('Could not delete pet type'), $e);
        }
        return true;
    }
}
