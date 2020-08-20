<?php
/*
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetKindCustomer\Test\Unit\Plugin;

use Magento\Customer\Api\AccountManagementInterface as AccountManager;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use PHPUnit\Framework\TestCase;
use Webjump\PetKindCustomer\Plugin\PetKindCustomerSavePlugin as Plugin;
use Webjump\PetKindCustomer\Api\SaveStrategyInterface;
use Psr\Log\LoggerInterface;

class PetKindCustomerSavePluginTest extends TestCase
{
    /**
     * @var SaveStrategyInterface
     */
    private $saveStrategyContext;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var AccountManager
     */
    private $accounManager;

    /**
     * @var CustomerInterface
     */
    private $customer;

    /**
     * @var Plugin
     */
    private $plugin;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);

        $this->saveStrategyContext = $this->createMock(SaveStrategyInterface::class);
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->accounManager = $this->createMock(AccountManager::class);
        $this->customer = $this->createMock(CustomerInterface::class);

        $this->plugin = $objectManager->getObject(Plugin::class, [
            'saveContext' => $this->saveStrategyContext,
            'logger' => $this->logger
        ]);
    }

    public function testBeforeExecuteShouldSaveAndLogAndReturnCustomer(): void
    {
        $this->saveStrategyContext->expects($this->once())
            ->method('execute');

        $this->logger->expects($this->once())
            ->method('info');

        $result = $this->plugin->afterCreateAccount($this->accounManager, $this->customer);
        $this->assertEquals($this->customer, $result);
    }

    public function testBeforeExecuteShouldLogOnException(): void
    {
        $this->saveStrategyContext->expects($this->once())
            ->method('execute')
            ->willThrowException(new CouldNotSaveException(__('Error')));

        $this->logger->expects($this->once())
            ->method('error');

        $result = $this->plugin->afterCreateAccount($this->accounManager, $this->customer);
        $this->assertEquals($this->customer, $result);
    }
}
