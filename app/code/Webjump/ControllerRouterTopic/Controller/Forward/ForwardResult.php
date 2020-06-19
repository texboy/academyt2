<?php
/**
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\ControllerRouterTopic\Controller\Forward;


use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;

class ForwardResult extends Action implements HttpGetActionInterface
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
    public function execute()
    {
        $result = $this->jsonFactory->create();
        return $result->setData(['forward' => 'success!']);
    }
}
