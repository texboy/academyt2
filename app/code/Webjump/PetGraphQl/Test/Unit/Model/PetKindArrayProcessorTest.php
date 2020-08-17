<?php
/*
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetGraphQl\Test\Unit\Model;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use Webjump\PetGraphQl\Model\PetKindArrayProcessor;

class PetKindArrayProcessorTest extends TestCase
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var PetKindArrayProcessor
     */
    private $petKindArrayProcessor;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->objectManager = new ObjectManager($this);
        $this->petKindArrayProcessor = $this->objectManager->getObject(PetKindArrayProcessor::class, []);
    }

    /**
     * @return void
     */
    public function testProcessArrayShouldReturnArray():void
    {
        $data = [
            "input" => [
                "name" => "test"
            ]
        ];
        $expectedResult = [
            "general" => [
                "name" => "test",
                "description" => ""
            ]
        ];
        $result = $this->petKindArrayProcessor->processArray($data);
        $this->assertTrue(is_array($result));
        $this->assertEquals($expectedResult, $result);
    }
}
