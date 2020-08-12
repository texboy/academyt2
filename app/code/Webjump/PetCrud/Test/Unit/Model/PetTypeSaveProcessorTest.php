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
use Webjump\PetCrud\Model\PetTypeSaveProcessor;
use Webjump\PetType\Api\Data\PetTypeInterface;
use Webjump\PetType\Api\PetTypeRepositoryInterface;
use Webjump\PetType\Api\Data\PetTypeInterfaceFactory;

class PetTypeSaveProcessorTest extends TestCase
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
     * @var PetTypeInterface
     */
    private $petType;

    /**
     * @var PetTypeRepositoryInterface
     */
    private $petTypeRepository;

    /**
     * @var PetTypeSaveProcessor
     */
    private $petTypeSaveProcessor;

    /**
     * @return void
     * @throws ReflectionException
     */
    public function setUp():void
    {
        $this->objectManager = new ObjectManager($this);

        $this->petTypeFactory = $this->getMockBuilder(PetTypeInterfaceFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMockForAbstractClass();
        $this->petType = $this->createMock(PetTypeInterface::class);
        $this->petTypeRepository = $this->createMock(PetTypeRepositoryInterface::class);

        $this->petTypeSaveProcessor = $this->objectManager->getObject(PetTypeSaveProcessor::class, [
            'petTypeFactory' => $this->petTypeFactory,
            'petTypeRepository' => $this->petTypeRepository
        ]);
    }

    /**
     * @return void
     * @throws CouldNotSaveException
     */
    public function testProcessShouldSaveNewPetType(): void
    {
        $requestData = [
            'general' => [
                'pet_type' => 'dog'
            ]
        ];

        $this->petTypeFactory->expects($this->once())
            ->method('create')
            ->willReturn($this->petType);

        $this->petType->expects($this->once())
            ->method('setPetType');

        $this->petTypeRepository->expects($this->once())
            ->method('save')
            ->with($this->petType);

        $this->petTypeSaveProcessor->process($requestData);
    }

    /**
     * @return void
     * @throws CouldNotSaveException
     */
    public function testProcessShouldEditPetType(): void
    {
        $requestData = [
            'general' => [
                'entity_id' => 1,
                'pet_type' => 'dog'
            ]
        ];

        $this->petTypeRepository->expects($this->once())
            ->method('getById')
            ->willReturn($this->petType);

        $this->petType->expects($this->once())
            ->method('setPetType');

        $this->petTypeRepository->expects($this->once())
            ->method('save')
            ->with($this->petType);

        $this->petTypeSaveProcessor->process($requestData);
    }
}
