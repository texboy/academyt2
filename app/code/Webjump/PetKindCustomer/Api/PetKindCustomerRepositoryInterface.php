<?php
/**
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetKindCustomer\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Webjump\PetKindCustomer\Api\Data\PetKindCustomerInterface;

interface PetKindCustomerRepositoryInterface
{
    /**
     * @param int $entityId
     * @return PetKindCustomerInterface
     */
    public function getById(int $entityId): PetKindCustomerInterface;

    /**
     * @param int $customerId
     * @return PetKindCustomerInterface
     */
    public function getByCustomerId(int $customerId): PetKindCustomerInterface;

    /**
     * @param SearchCriteriaInterface|null $searchCriteria
     * @return  PetKindCustomerSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null): PetKindCustomerSearchResultsInterface;

    /**
     * @param PetKindCustomerInterface $petKindCustomer
     * @return int
     * @throws CouldNotSaveException
     */
    public function save(PetKindCustomerInterface $petKindCustomer): int;

    /**
     * @param int $entityId
     * @throws CouldNotDeleteException
     * @return bool
     */
    public function deleteById(int $entityId): bool;
}
