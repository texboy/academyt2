<?php
/**
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetType\Api;

use Magento\Framework\DataObject;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Webjump\PetType\Api\Data\PetTypeInterface;

interface PetTypeRepositoryInterface
{
    /**
     * @param int $entityId
     * @throws NoSuchEntityException
     * @return PetTypeInterface
     */
    public function getById(int $entityId): PetTypeInterface;

    /**
     * @return  DataObject[]
     */
    public function getList(): array;

    /**
     * @param PetTypeInterface $pet
     * @throws CouldNotSaveException
     * @return int
     */
    public function save(PetTypeInterface $pet): int;
}
