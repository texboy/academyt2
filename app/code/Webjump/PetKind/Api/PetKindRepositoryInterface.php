<?php
/**
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetKind\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Webjump\PetKind\Api\Data\PetKindInterface;

interface PetKindRepositoryInterface
{
    /**
     * @param int $entityId
     * @return PetKindInterface
     */
    public function getById(int $entityId): PetKindInterface;

    /**
     * @param SearchCriteriaInterface|null $searchCriteria
     * @return  PetKindSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null): PetKindSearchResultsInterface;

    /**
     * @param PetKindInterface $petKind
     * @return int
     * @throws CouldNotSaveException
     */
    public function save(PetKindInterface $petKind): int;

    /**
     * @param int $entityId
     * @throws CouldNotDeleteException
     * @return bool
     */
    public function deleteById(int $entityId): bool;
}
