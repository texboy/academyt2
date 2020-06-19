<?php
/**
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\ControllerRouterTopic\Controller\Raw;


use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\Raw;
use Magento\Framework\Controller\Result\RawFactory;

class Index extends Action implements HttpGetActionInterface
{
    /**
     * @var RawFactory
     */
    private $rawFactory;

    /**
     * @param Context $context
     * @param RawFactory $rawFactory
     */
    public function __construct(
        Context $context,
        RawFactory $rawFactory
    ) {
        parent::__construct($context);
        $this->rawFactory = $rawFactory;
    }
    /**
     * @inheritDoc
     */
    public function execute(): Raw
    {
        $result = $this->rawFactory->create();
        return $result->setContents("Raw!");
    }
}
