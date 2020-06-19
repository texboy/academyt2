<?php
/**
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\DependencyInjectionTopic\Plugin;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Result\Page;
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
    private $customLogger;

    /**
     * PluginTest constructor.
     * @param LoggerInterface $customLogger
     */
    public function __construct(
        LoggerInterface $customLogger
    ) {
        $this->customLogger = $customLogger;
    }


    /**
     * @param Action $subject
     */
    public function beforeDispatch(Action $subject): void
    {
        $this->customLogger->debug('beforeDispatch called');
    }

    /**
     * @param Action $subject
     * @param callable $proceed
     * @param RequestInterface $request
     * @return Page
     */
    public function aroundDispatch(Action $subject, callable $proceed, RequestInterface $request)
    {
        $this->customLogger->debug('aroundDispatch called before proceed');
        $returnValue = $proceed($request);
        $this->customLogger->debug('aroundDispatch called after proceed');
        return $returnValue;
    }

    /**
     * @param Action $subject
     * @param Page $result
     * @return object
     */
    public function afterDispatch(Action $subject, $result)
    {
        $this->customLogger->debug('afterDispatch called');
        return $result;
    }
}
