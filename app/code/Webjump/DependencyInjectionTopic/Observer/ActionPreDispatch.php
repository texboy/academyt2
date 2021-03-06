<?php
/**
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

namespace Webjump\DependencyInjectionTopic\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;

/**
 * @codeCoverageIgnore
 */
class ActionPreDispatch implements ObserverInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * ActionPreDispatch constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     */
    public function execute(Observer $observer)
    {
        $this->logger->debug('event controller_action_predispatch observed');
    }
}
