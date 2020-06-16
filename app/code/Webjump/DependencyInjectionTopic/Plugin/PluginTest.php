<?php
/**
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

namespace Webjump\DependencyInjectionTopic\Plugin;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\RequestInterface;
use Psr\Log\LoggerInterface;

/**
 * Class PluginTest
 * @package Webjump\DependencyInjectionTopic\Plugin
 */
class PluginTest
{

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * PluginTest constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param Action $subject
     */
    public function beforeDispatch(Action $subject)
    {
        $this->logger->info('beforeDispatch called');
    }

    /**
     * @param Action $subject
     * @param callable $proceed
     */
    public function aroundDispatch(Action $subject, callable $proceed, RequestInterface $request)
    {
        $this->logger->info('aroundDispatch called before proceed');
        $returnValue = $proceed($request);
        $this->logger->info('aroundDispatch called after proceed');
        return $returnValue;
    }

    /**
     * @param Action $subject
     * @param $result
     */
    public function afterDispatch(Action $subject, $result)
    {
        $this->logger->info('afterDispatch called');
        return $result;
    }
}
