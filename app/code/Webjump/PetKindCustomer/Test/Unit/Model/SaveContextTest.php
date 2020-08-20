<?php
/*
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetKindCustomer\Test\Unit\Model;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use PHPUnit\Framework\TestCase;
use Webjump\PetKindCustomer\Api\SaveStrategyInterface;
use Webjump\PetKindCustomer\Model\SaveContext;

class SaveContextTest extends TestCase
{
    /**
     * @var SaveStrategyInterface
     */
    private $strategy;

    /**
     * @var CustomerInterface
     */
    private $customer;

    /**
     * @var SaveContext
     */
    private $saveContext;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        $this->strategy = $this->createMock(SaveContext::class);
        $this->customer = $this->createMock(CustomerInterface::class);

        $this->saveContext = $objectManager->getObject(SaveContext::class, [
            'strategies' => [$this->strategy]
        ]);
    }

    /**
     * @return void
     * @throws NoSuchEntityException|CouldNotSaveException
     */
    public function testExecuteShouldCallStrategies(): void
    {
        $this->strategy->expects($this->once())
            ->method('execute')
            ->with($this->customer);

        $this->saveContext->execute($this->customer);
    }
}
