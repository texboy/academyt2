<?php
/**
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\DatabaseTopic\Test\Unit\Model;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use PHPUnit\Framework\TestCase;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Webjump\DatabaseTopic\Api\Data\PetInterfaceFactory;
use Webjump\DatabaseTopic\Model\Pet;
use Webjump\DatabaseTopic\Model\PetRepository;
use Webjump\DatabaseTopic\Model\ResourceModel\PetResourceModel;

class PetRepositoryTest extends TestCase
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var PetInterfaceFactory
     */
    private $petFactory;

    /**
     * @var Pet
     */
    private $pet;

    /**
     * @var PetResourceModel
     */
    private $petResourceModel;

    /**
     * @var PetRepository
     */
    private $petRepository;

    public function setUp()
    {
        $this->objectManager = new ObjectManager($this);

        $this->petFactory = $this->getMockBuilder(PetInterfaceFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->pet = $this->getMockBuilder(Pet::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->petResourceModel = $this->getMockBuilder(PetResourceModel::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->petRepository = $this->objectManager->getObject(PetRepository::class, [
            'petFactory' => $this->petFactory,
            'petResourceModel' => $this->petResourceModel
        ]);
    }

    public function testGetByIdShouldReturnPet(): void
    {
        $entityId = 1;

        $this->pet->expects($this->once())
            ->method('getEntityId')
            ->willReturn($entityId);

        $this->petFactory->expects($this->once())
            ->method('create')
            ->willReturn($this->pet);

        $this->petResourceModel->expects($this->once())
            ->method('load')
            ->with($this->pet, $entityId);

        $result = $this->petRepository->getById($entityId);
        $this->assertEquals($result, $this->pet);
    }

    public function testGetByIdShouldThrowNoSuchEntityException()
    {
        $entityId = 1;

        $this->pet->expects($this->once())
            ->method('getEntityId')
            ->willReturn(null);

        $this->petFactory->expects($this->once())
            ->method('create')
            ->willReturn($this->pet);

        $this->petResourceModel->expects($this->once())
            ->method('load')
            ->with($this->pet, $entityId);

        $this->expectException(NoSuchEntityException::class);
        $this->petRepository->getById($entityId);
    }

    public function testSaveShouldReturnEntityId(): void
    {
        $entityId = 1;

        $this->pet->expects($this->once())
            ->method('getEntityId')
            ->willReturn($entityId);

        $this->petResourceModel->expects($this->once())
            ->method('save')
            ->with($this->pet);

        $result = $this->petRepository->save($this->pet);
        $this->assertEquals($result, $entityId);
    }

    public function testSaveShouldReturnThrowCouldNotSaveException(): void
    {
        $this->petResourceModel->expects($this->once())
            ->method('save')
            ->willThrowException(new \Exception("error"));

        $this->expectException(CouldNotSaveException::class);
        $this->petRepository->save($this->pet);
    }
}
