<?php
/*
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetGraphQl\Test\Unit\Model\Resolver;

use Exception;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use Webjump\PetKind\Api\PetKindRepositoryInterface as Repository;
use Webjump\PetKind\Api\PetKindSearchResultsInterface as SearchResultsInterface;
use Webjump\PetKind\Api\Data\PetKindInterface as Model;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Webjump\PetGraphQl\Model\Resolver\PetKindsResolver as Resolver;

class PetKindsResolverTest extends TestCase
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var Repository
     */
    private $repository;

    /**
     * @var SearchResultsInterface
     */
    private $searchResults;

    /**
     * @var Model
     */
    private $model;

    /**
     * @var Field
     */
    private $field;

    /**
     * @var ContextInterface
     */
    private $context;

    /**
     * @var ResolveInfo
     */
    private $resolveInfo;

    /**
     * @var Resolver
     */
    private $resolver;

    /**
     * @return void
     * @throws ReflectionException
     */
    public function setUp(): void
    {
        $this->objectManager = new ObjectManager($this);
        $this->repository = $this->createMock(Repository::class);
        $this->searchResults = $this->createMock(SearchResultsInterface::class);
        $this->model = $this->createMock(Model::class);
        $this->field = $this->createMock(Field::class);
        $this->context = $this->createMock(ContextInterface::class);
        $this->resolveInfo = $this->createMock(ResolveInfo::class);
        $this->resolver = $this->objectManager->getObject(Resolver::class, [
            'petKindRepository' => $this->repository
        ]);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testResolveShouldReturnArray(): void
    {
        $this->repository->expects($this->once())
            ->method('getList')
            ->willReturn($this->searchResults);

        $this->searchResults->expects($this->once())
            ->method('getItems')
            ->willReturn([$this->model]);

        $result = $this->resolver->resolve($this->field, $this->context, $this->resolveInfo);
        $this->assertTrue(is_array($result));
    }
}
