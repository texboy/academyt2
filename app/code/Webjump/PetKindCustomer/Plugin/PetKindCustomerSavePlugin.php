<?php
/*
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetKindCustomer\Plugin;

use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Api\Data\CustomerInterface;
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
     * @param AccountManagementInterface $subject
     * @param $result
     * @return CustomerInterface
     */
    public function afterCreateAccount(AccountManagementInterface $subject, $result): CustomerInterface
    {
        try {
            $this->saveContext->execute($result);
            $this->logger->info(__('pet kind customer save executed without errors'));
        } catch (CouldNotSaveException | NoSuchEntityException $e) {
            $this->logger->error($e->getMessage());
        }
        return $result;
    }
}
