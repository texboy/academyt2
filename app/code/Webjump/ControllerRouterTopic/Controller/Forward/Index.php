<?php
/**
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\ControllerRouterTopic\Controller\Forward;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;

/**
 * @codeCoverageIgnore
 */
class Index extends Action implements HttpGetActionInterface
{
    /**
     * @inheritDoc
     */
    public function execute()
    {
        $this->_forward('ForwardResult', 'Forward');
    }
}
