<?php
/*
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetCrud\Test\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use Webjump\PetCrud\Ui\Component\Listing\Column\Actions as Column;

class ActionsTest extends TestCase
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var ContextInterface
     */
    private $context;

    /**
     * @var UiComponentFactory
     */
    private $uiComponentFactory;

    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * @var Column
     */
    private $column;

    /**
     * @return void
     * @throws ReflectionException
     */
    public function setUp(): void
    {
        $this->objectManager = new ObjectManager($this);

        $this->context = $this->createMock(ContextInterface::class);
        $this->uiComponentFactory = $this->createMock(UiComponentFactory::class);
        $this->urlBuilder = $this->createMock(UrlInterface::class);

        $this->column = $this->objectManager->getObject(Column::class, [
            'context' => $this->context,
            'uiComponentFactory' => $this->uiComponentFactory,
            'urlBuilder' => $this->urlBuilder
        ]);
    }

    /**
     * @return void
     */
    public function testGetButtonDataShouldReturnArray(): void
    {
        $requestData = [
            'data' => [
                'items' => [
                    [
                        'entity_id' => 1
                    ]
                ]
            ]
        ];
        $this->urlBuilder->expects($this->exactly(2))
            ->method('getUrl')
            ->willReturn('www.test.com');
        $result = $this->column->prepareDataSource($requestData);
        $this->assertTrue(is_array($result));
    }
}
