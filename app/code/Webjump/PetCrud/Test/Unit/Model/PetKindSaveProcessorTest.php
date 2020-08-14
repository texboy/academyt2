<?php
/*
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetCrud\Test\Unit\Model;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use Webjump\PetCrud\Model\PetKindSaveProcessor;
use Webjump\PetKind\Api\Data\PetKindInterface;
use Webjump\PetKind\Api\PetKindRepositoryInterface;
use Webjump\PetKind\Api\Data\PetKindInterfaceFactory;

class PetKindSaveProcessorTest extends TestCase
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var PetKindInterfaceFactory
     */
    private $petKindFactory;

    /**
     * @var PetKindInterface
     */
    private $petKind;

    /**
     * @var PetKindRepositoryInterface
     */
    private $petKindRepository;

    /**
     * @var PetKindSaveProcessor
     */
    private $petKindSaveProcessor;

    /**
     * @return void
     * @throws ReflectionException
     */
    public function setUp():void
    {
        $this->objectManager = new ObjectManager($this);

        $this->petKindFactory = $this->getMockBuilder(petKindInterfaceFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMockForAbstractClass();
        $this->petKind = $this->createMock(petKindInterface::class);
        $this->petKindRepository = $this->createMock(petKindRepositoryInterface::class);

        $this->petKindSaveProcessor = $this->objectManager->getObject(petKindSaveProcessor::class, [
            'petKindFactory' => $this->petKindFactory,
            'petKindRepository' => $this->petKindRepository
        ]);
    }

    /**
     * @return void
     * @throws CouldNotSaveException
     */
    public function testProcessShouldSaveNewPetKind(): void
    {
        $requestData = [
            'general' => [
                'name' => 'dog',
                'description' => 'test'
            ]
        ];

        $this->petKindFactory->expects($this->once())
            ->method('create')
            ->willReturn($this->petKind);

        $this->petKind->expects($this->once())
            ->method('setName');

        $this->petKind->expects($this->once())
            ->method('setDescription');

        $this->petKindRepository->expects($this->once())
            ->method('save')
            ->with($this->petKind);

        $this->petKindSaveProcessor->process($requestData);
    }

    /**
     * @return void
     * @throws CouldNotSaveException
     */
    public function testProcessShouldEditPetKind(): void
    {
        $requestData = [
            'general' => [
                'entity_id' => 1,
                'name' => 'dog',
                'description' => 'test'
            ]
        ];

        $this->petKindRepository->expects($this->once())
            ->method('getById')
            ->willReturn($this->petKind);

        $this->petKind->expects($this->once())
            ->method('setName');

        $this->petKind->expects($this->once())
            ->method('setDescription');

        $this->petKindRepository->expects($this->once())
            ->method('save')
            ->with($this->petKind);

        $this->petKindSaveProcessor->process($requestData);
    }
}
