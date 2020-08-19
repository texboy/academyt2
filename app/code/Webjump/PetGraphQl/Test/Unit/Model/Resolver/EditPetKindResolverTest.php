<?php
/*
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetGraphQl\Test\Unit\Model\Resolver;

use Exception;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use Webjump\PetCrud\Api\PetKindSaveProcessorInterface;
use Webjump\PetGraphQl\Api\PetKindArrayProcessorInterface;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Webjump\PetGraphQl\Model\Resolver\EditPetKindResolver as Resolver;

class EditPetKindResolverTest extends TestCase
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var PetKindArrayProcessorInterface
     */
    private $arrayProcessor;

    /**
     * @var PetKindSaveProcessorInterface
     */
    private $saveProcessor;
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
        $this->arrayProcessor = $this->createMock(PetKindArrayProcessorInterface::class);
        $this->saveProcessor = $this->createMock(PetKindSaveProcessorInterface::class);
        $this->field = $this->createMock(Field::class);
        $this->context = $this->createMock(ContextInterface::class);
        $this->resolveInfo = $this->createMock(ResolveInfo::class);
        $this->resolver = $this->objectManager->getObject(Resolver::class, [
            'arrayProcessor' => $this->arrayProcessor,
            'saveProcessor' => $this->saveProcessor
        ]);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testResolveShouldReturnPetKind(): void
    {
        $args = ['input' => 'data'];
        $processedArray = ['general' => 'data'];

        $this->arrayProcessor->expects($this->once())
            ->method('processArray')
            ->with($args)
            ->willReturn($processedArray);

        $this->saveProcessor->expects($this->once())
            ->method('process')
            ->with($processedArray);

        $result = $this->resolver->resolve($this->field, $this->context, $this->resolveInfo, null, $args);
        $this->assertTrue($result);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testResolveShouldThrowException(): void
    {
        $args = ['input' => 'data'];
        $processedArray = ['general' => 'data'];

        $this->arrayProcessor->expects($this->once())
            ->method('processArray')
            ->with($args)
            ->willReturn($processedArray);

        $this->saveProcessor->expects($this->once())
            ->method('process')
            ->willThrowException(new CouldNotSaveException(__('error')));

        $this->expectException(GraphQlInputException::class);
        $this->resolver->resolve($this->field, $this->context, $this->resolveInfo, null, $args);
    }
}
