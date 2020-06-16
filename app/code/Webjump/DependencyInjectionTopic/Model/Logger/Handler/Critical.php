<?php
/**
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

namespace Webjump\DependencyInjectionTopic\Model\Logger\Handler;


use Monolog\Logger;

class Critical extends \Magento\Framework\Logger\Handler\Base
{
    /**
     * File name
     *
     * @var string
     */
    protected $fileName = '/var/log/custom-critical.log';

    /**
     * Logging level
     *
     * @var int
     */
    protected $loggerType = Logger::CRITICAL;

}
