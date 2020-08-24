<?php
/*
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetKindCustomer\Test\Unit\Plugin;

use Magento\Customer\Controller\Account\EditPost as Action;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\Redirect as Redirect;
use Magento\Framework\Exception\CouldNotSaveException;
use PHPUnit\Framework\TestCase;
use ReflectionException;
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
     * @var Action
     */
    private $action;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var Redirect
     */
    private $redirect;

    /**
     * @var Plugin
     */
    private $plugin;

    /**
     * @return void
     * @throws ReflectionException
     */
    public function setUp(): void
    {
        $objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);

        $this->saveStrategyContext = $this->createMock(SaveStrategyInterface::class);
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->action = $this->createMock(Action::class);
        $this->request = $this->createMock(RequestInterface::class);
        $this->redirect = $this->createMock(Redirect::class);

        $this->plugin = $objectManager->getObject(Plugin::class, [
            'saveContext' => $this->saveStrategyContext,
            'logger' => $this->logger
        ]);
    }

    public function testBeforeExecuteShouldSaveAndLogAndReturnCustomer(): void
    {
        $this->action->expects($this->once())
            ->method('getRequest')
            ->willReturn($this->request);

        $this->saveStrategyContext->expects($this->once())
            ->method('execute');

        $this->logger->expects($this->once())
            ->method('info');

        $result = $this->plugin->afterExecute($this->action, $this->redirect);
        $this->assertEquals($this->redirect, $result);
    }

    public function testBeforeExecuteShouldLogOnException(): void
    {
        $this->action->expects($this->once())
            ->method('getRequest')
            ->willReturn($this->request);

        $this->saveStrategyContext->expects($this->once())
            ->method('execute')
            ->willThrowException(new CouldNotSaveException(__('Error')));

        $this->logger->expects($this->once())
            ->method('error');

        $result = $this->plugin->afterExecute($this->action, $this->redirect);
        $this->assertEquals($this->redirect, $result);
    }
}
