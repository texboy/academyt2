<?php
/**
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetType\Test\Unit\Model;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use PHPUnit\Framework\TestCase;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Webjump\PetType\Api\Data\PetTypeInterfaceFactory;
use Webjump\PetType\Model\ResourceModel\PetType\CollectionFactory;
use Webjump\PetType\Model\ResourceModel\PetType\Collection;
use Webjump\PetType\Model\PetType;
use Webjump\PetType\Model\PetTypeRepository;
use Webjump\PetType\Model\ResourceModel\PetTypeResourceModel;

class PetTypeRepositoryTest extends TestCase
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var PetTypeInterfaceFactory
     */
    private $petTypeFactory;

    /**
     * @var PetType
     */
    private $petType;

    /**
     * @var PetTypeResourceModel
     */
    private $petTypeResourceModel;

    /**
     * @var PetTypeRepository
     */
    private $petTypeRepository;

    /**
     * @var CollectionFactory
     */
    private $petTypeCollectionFactory;

    /**
     * @var Collection
     */
    private $petTypeCollection;

    public function setUp()
    {
        $this->objectManager = new ObjectManager($this);

        $this->petTypeFactory = $this->getMockBuilder(PetTypeInterfaceFactory::class)
            ->setMethods(['create'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->petType = $this->getMockBuilder(PetType::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->petTypeResourceModel = $this->getMockBuilder(PetTypeResourceModel::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->petTypeCollectionFactory = $this->getMockBuilder(CollectionFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        $this->petTypeCollection = $this->getMockBuilder(Collection::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->petTypeRepository = $this->objectManager->getObject(PetTypeRepository::class, [
            'petTypeFactory' => $this->petTypeFactory,
            'petTypeResourceModel' => $this->petTypeResourceModel,
            'petTypeCollectionFactory' => $this->petTypeCollectionFactory
        ]);
    }

    public function testGetByIdShouldReturnPetType(): void
    {
        $entityId = 1;

        $this->petTypeFactory->expects($this->once())
            ->method('create')
            ->willReturn($this->petType);

        $this->petTypeResourceModel->expects($this->once())
            ->method('load')
            ->with($this->petType, $entityId);

        $result = $this->petTypeRepository->getById($entityId);
        $this->assertEquals($result, $this->petType);
    }

    public function testSaveShouldReturnEntityId(): void
    {
        $entityId = 1;

        $this->petType->expects($this->once())
            ->method('getEntityId')
            ->willReturn($entityId);

        $this->petTypeResourceModel->expects($this->once())
            ->method('save')
            ->with($this->petType);

        $result = $this->petTypeRepository->save($this->petType);
        $this->assertEquals($result, $entityId);
    }

    public function testSaveShouldReturnThrowCouldNotSaveException(): void
    {
        $this->petTypeResourceModel->expects($this->once())
            ->method('save')
            ->willThrowException(new \Exception("error"));

        $this->expectException(CouldNotSaveException::class);
        $this->petTypeRepository->save($this->petType);
    }

    public function testGetListShouldReturnArray(): void
    {
        $items = [];
        $this->petTypeCollectionFactory->expects($this->once())
            ->method('create')
            ->willReturn($this->petTypeCollection);

        $this->petTypeCollection->expects($this->once())
            ->method('getItems')
            ->willReturn($items);

        $result = $this->petTypeRepository->getList();
        $this->assertEquals($items, $result);
    }

    public function testDeleteShouldReturnTrue(): void
    {
        $entityId = 1;

        $this->petTypeFactory->expects($this->once())
            ->method('create')
            ->willReturn($this->petType);

        $this->petTypeResourceModel->expects($this->once())
            ->method('load')
            ->with($this->petType, $entityId);

        $this->petTypeResourceModel->expects($this->once())
            ->method('delete')
            ->with($this->petType);

        $result = $this->petTypeRepository->deleteById($entityId);
        $this->assertTrue($result);
    }

    public function testDeleteShouldReturnThrowCouldNotDeleteException(): void
    {
        $entityId = 1;

        $this->petTypeFactory->expects($this->once())
            ->method('create')
            ->willReturn($this->petType);

        $this->petTypeResourceModel->expects($this->once())
            ->method('load')
            ->with($this->petType, $entityId);

        $this->petTypeResourceModel->expects($this->once())
            ->method('delete')
            ->willThrowException(new \Exception("error"));

        $this->expectException(CouldNotDeleteException::class);
        $this->petTypeRepository->deleteById($entityId);
    }
}
