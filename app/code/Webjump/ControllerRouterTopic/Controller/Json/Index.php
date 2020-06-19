<?php
/**
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\ControllerRouterTopic\Controller\Json;


use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\Result\Json;

class Index extends Action implements HttpGetActionInterface
{
    /**
     * @var JsonFactory
     */
    private $jsonFactory;

    /**
     * @param Context $context
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
    }
    /**
     * @inheritDoc
     */
    public function execute(): Json
    {
        $result = $this->jsonFactory->create();
        return $result->setData(['type' => 'json!']);
    }
}
