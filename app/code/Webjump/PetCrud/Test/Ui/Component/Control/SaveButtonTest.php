<?php
/*
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetCrud\Test\Ui\Component\Control;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use Webjump\PetCrud\Ui\Component\Control\SaveButton as Button;

class SaveButtonTest extends TestCase
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

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

        $this->button = $this->objectManager->getObject(Button::class, []);
    }

    /**
     * @return void
     */
    public function testGetButtonDataShouldReturnArray(): void
    {
        $result = $this->button->getButtonData();
        $this->assertTrue(is_array($result));
    }
}
