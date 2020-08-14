<?php
/*
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetCrud\Test\Unit\Ui\Component\Control;

use Magento\Framework\UrlInterface;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use Webjump\PetCrud\Ui\Component\Control\BackButton as Button;

class BackButtonTest extends TestCase
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * @var Button
     */
    private $button;

    /**
     * @return void
     * @throws ReflectionException
     */
    public function setUp(): void
    {
        $this->objectManager = new ObjectManager($this);

        $this->urlBuilder = $this->createMock(UrlInterface::class);

        $this->button = $this->objectManager->getObject(Button::class, [
            'urlBuilder' => $this->urlBuilder
        ]);
    }

    /**
     * @return void
     */
    public function testGetButtonDataShouldReturnArray(): void
    {
        $this->urlBuilder->expects($this->once())
            ->method('getUrl')
            ->willReturn('www.test.com');
        $result = $this->button->getButtonData();
        $this->assertTrue(is_array($result));
    }
}
