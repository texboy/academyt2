<?php
/**
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\DependencyInjectionTopic\Cron;

use Psr\Log\LoggerInterface;

/**
 * Class CronTest
 * @package Webjump\DependencyInjectionTopic\Cron
 */
class CronTest
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * CronTest constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    
    public function execute(): void
    {
        $this->logger->debug('cron test executed successfully');
    }
}
