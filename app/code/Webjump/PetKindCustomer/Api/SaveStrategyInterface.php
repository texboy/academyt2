<?php
/*
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetKindCustomer\Api;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

interface SaveStrategyInterface
{
    /**
     * @param CustomerInterface $customer
     * @throws CouldNotSaveException
     * @throws NoSuchEntityException
     */
    public function execute(CustomerInterface $customer): void;
}
