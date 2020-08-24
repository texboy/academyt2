<?php
/*
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetKindCustomer\Test\Unit\ViewModel;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use Webjump\PetKind\Api\Data\PetKindInterface;
use Webjump\PetKind\Api\PetKindRepositoryInterface;
use Webjump\PetKind\Api\PetKindSearchResultsInterface;
use Webjump\PetKindCustomer\ViewModel\PetKindOptions;

class PetKindOptionsTest extends TestCase
{
    /**
     * @var PetKindRepositoryInterface
     */
    private $repository;

    /**
     * @var PetKindSearchResultsInterface
     */
    private $searchResults;

    /**
     * @var PetKindInterface
     */
    private $model;

    /**
     * @var PetKindOptions
     */
    private $viewModel;

    /**
     * @return void
     * @throws ReflectionException
     */
    public function setUp(): void
    {
        $objectManager = new ObjectManager($this);

        $this->repository = $this->createMock(PetKindRepositoryInterface::class);
        $this->searchResults = $this->createMock(PetKindSearchResultsInterface::class);
        $this->model = $this->createMock(PetKindInterface::class);

        $this->viewModel = $objectManager->getObject(PetKindOptions::class, [
            'petKindRepository' => $this->repository
        ]);
    }

    /**
     * @return void
     */
    public function testGetPetKindOptionsShouldReturnArray(): void
    {
        $value = "1";
        $label = "Dog";

        $this->repository->expects($this->once())
            ->method('getList')
            ->willReturn($this->searchResults);

        $this->searchResults->expects($this->once())
            ->method('getItems')
            ->willReturn([$this->model]);

        $this->model->expects($this->exactly(2))
            ->method('getEntityId')
            ->willReturn($value);

        $this->model->expects($this->once())
            ->method('getName')
            ->willReturn($label);

        $result = $this->viewModel->getPetKindOptions();
        $this->assertTrue(is_array($result));
    }

    /**
     * @return void
     */
    public function testGetPetKindOptionsShouldReturnArrayWithSelected(): void
    {
        $value = "1";
        $label = "Dog";
        $expectedResult = [
            ["value" => "", "label" => "", "selected" => false],
            ["value" => "1", "label" => "Dog", "selected" => true]
        ];

        $this->repository->expects($this->once())
            ->method('getList')
            ->willReturn($this->searchResults);

        $this->searchResults->expects($this->once())
            ->method('getItems')
            ->willReturn([$this->model]);

        $this->model->expects($this->exactly(2))
            ->method('getEntityId')
            ->willReturn($value);

        $this->model->expects($this->once())
            ->method('getName')
            ->willReturn($label);

        $result = $this->viewModel->getPetKindOptions((int) $value);
        $this->assertEquals($expectedResult, $result);
    }
}
