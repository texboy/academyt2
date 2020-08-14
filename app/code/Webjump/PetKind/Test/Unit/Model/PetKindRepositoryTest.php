<?php
/**
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetKind\Test\Unit\Model;

use Magento\Framework\Api\SearchCriteria;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use PHPUnit\Framework\TestCase;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Webjump\PetKind\Api\Data\PetKindInterfaceFactory as ModelFactory;
use Webjump\PetKind\Api\PetKindSearchResultsInterfaceFactory as SearchResultsFactory;
use Webjump\PetKind\Api\PetKindSearchResultsInterface as SearchResults;
use Webjump\PetKind\Model\ResourceModel\PetKind\CollectionFactory;
use Webjump\PetKind\Model\ResourceModel\PetKind\Collection;
use Webjump\PetKind\Model\PetKind as Model;
use Webjump\PetKind\Model\PetKindRepository as Repository;
use Webjump\PetKind\Model\ResourceModel\PetKindResourceModel as ResourceModel;

class PetKindRepositoryTest extends TestCase
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var ModelFactory
     */
    private $modelFactory;

    /**
     * @var Model
     */
    private $model;

    /**
     * @var ResourceModel
     */
    private $resourceModel;

    /**
     * @var Repository
     */
    private $repository;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var SearchCriteria
     */
    private $searchCriteria;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var Collection
     */
    private $collection;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var SearchResultsFactory
     */
    private $searchResultsFactory;

    /**
     * @var SearchResults
     */
    private $searchResults;


    public function setUp()
    {
        $this->objectManager = new ObjectManager($this);
        $this->modelFactory = $this->getMockBuilder(ModelFactory::class)
            ->setMethods(['create'])
            ->disableOriginalConstructor()
            ->getMock();
        $this->model = $this->getMockBuilder(Model::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->resourceModel = $this->getMockBuilder(ResourceModel::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->searchCriteriaBuilder = $this->createMock(SearchCriteriaBuilder::class);
        $this->searchCriteria = $this->createMock(SearchCriteria::class);
        $this->collectionFactory = $this->getMockBuilder(CollectionFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();
        $this->collection = $this->getMockBuilder(Collection::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->collectionProcessor = $this->createMock(CollectionProcessorInterface::class);
        $this->searchResultsFactory = $this->createMock(SearchResultsFactory::class);
        $this->searchResults = $this->createMock(SearchResults::class);

        $this->repository = $this->objectManager->getObject(Repository::class, [
            'modelFactory' => $this->modelFactory,
            'resourceModel' => $this->resourceModel,
            'searchCriteriaBuilder' => $this->searchCriteriaBuilder,
            'collectionFactory' => $this->collectionFactory,
            'collectionProcessor' => $this->collectionProcessor,
            'petKindSearchResultsFactory' => $this->searchResultsFactory
        ]);
    }

    public function testGetByIdShouldReturnPetType(): void
    {
        $entityId = 1;

        $this->modelFactory->expects($this->once())
            ->method('create')
            ->willReturn($this->model);

        $this->resourceModel->expects($this->once())
            ->method('load')
            ->with($this->model, $entityId);

        $result = $this->repository->getById($entityId);
        $this->assertEquals($result, $this->model);
    }

    public function testSaveShouldReturnEntityId(): void
    {
        $entityId = 1;

        $this->model->expects($this->once())
            ->method('getEntityId')
            ->willReturn($entityId);

        $this->resourceModel->expects($this->once())
            ->method('save')
            ->with($this->model);

        $result = $this->repository->save($this->model);
        $this->assertEquals($result, $entityId);
    }

    public function testSaveShouldReturnThrowCouldNotSaveException(): void
    {
        $this->resourceModel->expects($this->once())
            ->method('save')
            ->willThrowException(new \Exception("error"));

        $this->expectException(CouldNotSaveException::class);
        $this->repository->save($this->model);
    }

    public function testGetListShouldCreateSearchCriteriaAndReturnSearchResultsInterface(): void
    {
        $items = [];
        $this->collectionFactory->expects($this->once())
            ->method('create')
            ->willReturn($this->collection);

        $this->searchCriteriaBuilder->expects($this->once())
            ->method('create')
            ->willReturn($this->searchCriteria);

        $this->searchResultsFactory->expects($this->once())
            ->method('create')
            ->willReturn($this->searchResults);

        $this->searchResults->expects($this->once())
            ->method('setItems')
            ->willReturnSelf();

        $this->collection->expects($this->once())
            ->method('getItems')
            ->willReturn($items);

        $this->collection->expects($this->once())
            ->method('getSize')
            ->willReturn(count($items));

        $this->searchResults->expects($this->once())
            ->method('setSearchCriteria')
            ->with($this->searchCriteria)
            ->willReturnSelf();

        $result = $this->repository->getList();
        $this->assertEquals($this->searchResults, $result);
    }

    public function testGetListShouldProcessCollectionAndReturnSearchResultsInterface(): void
    {
        $items = [];
        $this->collectionFactory->expects($this->once())
            ->method('create')
            ->willReturn($this->collection);

        $this->collectionProcessor->expects($this->once())
            ->method('process')
            ->with($this->searchCriteria, $this->collection);

        $this->searchResultsFactory->expects($this->once())
            ->method('create')
            ->willReturn($this->searchResults);

        $this->searchResults->expects($this->once())
            ->method('setItems')
            ->willReturnSelf();

        $this->collection->expects($this->once())
            ->method('getItems')
            ->willReturn($items);

        $this->collection->expects($this->once())
            ->method('getSize')
            ->willReturn(count($items));

        $this->searchResults->expects($this->once())
            ->method('setSearchCriteria')
            ->with($this->searchCriteria)
            ->willReturnSelf();

        $result = $this->repository->getList($this->searchCriteria);
        $this->assertEquals($this->searchResults, $result);
    }

    public function testDeleteShouldReturnTrue(): void
    {
        $entityId = 1;

        $this->modelFactory->expects($this->once())
            ->method('create')
            ->willReturn($this->model);

        $this->resourceModel->expects($this->once())
            ->method('load')
            ->with($this->model, $entityId);

        $this->resourceModel->expects($this->once())
            ->method('delete')
            ->with($this->model);

        $result = $this->repository->deleteById($entityId);
        $this->assertTrue($result);
    }

    public function testDeleteShouldReturnThrowCouldNotDeleteException(): void
    {
        $entityId = 1;

        $this->modelFactory->expects($this->once())
            ->method('create')
            ->willReturn($this->model);

        $this->resourceModel->expects($this->once())
            ->method('load')
            ->with($this->model, $entityId);

        $this->resourceModel->expects($this->once())
            ->method('delete')
            ->willThrowException(new \Exception("error"));

        $this->expectException(CouldNotDeleteException::class);
        $this->repository->deleteById($entityId);
    }
}
