<?php
/*
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetKindCustomer\Api;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

interface SaveStrategyInterface
{
    /**
     * @param RequestInterface $request
     * @throws CouldNotSaveException
     * @throws NoSuchEntityException
     */
    public function execute(RequestInterface $request): void;
}
