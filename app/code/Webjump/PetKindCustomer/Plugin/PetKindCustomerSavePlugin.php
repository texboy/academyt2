<?php
/*
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetKindCustomer\Plugin;

use Magento\Customer\Controller\Account\EditPost as Action;
use Magento\Framework\Controller\Result\Redirect as Redirect;
use Webjump\PetKindCustomer\Api\SaveStrategyInterface;
use Psr\Log\LoggerInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class PetKindCustomerSavePlugin
{
    /**
     * @var SaveStrategyInterface
     */
    private $saveContext;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * PetKindCustomerSavePlugin constructor.
     * @param SaveStrategyInterface $saveContext
     * @param LoggerInterface $logger
     */
    public function __construct(
        SaveStrategyInterface $saveContext,
        LoggerInterface $logger
    ) {
        $this->saveContext = $saveContext;
        $this->logger = $logger;
    }

    /**
     * @param Action $subject
     * @param Redirect $result
     * @return Redirect
     */
    public function afterExecute(Action $subject, $result): Redirect
    {
        try {
            $this->saveContext->execute($subject->getRequest());
            $this->logger->info(__('pet kind customer save executed without errors'));
        } catch (CouldNotSaveException | NoSuchEntityException $e) {
            $this->logger->error($e->getMessage());
        }

        return $result;
    }
}
