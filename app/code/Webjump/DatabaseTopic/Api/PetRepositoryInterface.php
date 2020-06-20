<?php
/**
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\DatabaseTopic\Api;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Webjump\DatabaseTopic\Api\Data\PetInterface;

interface PetRepositoryInterface
{
    /**
     * @param int $entityId
     * @throws NoSuchEntityException
     * @return PetInterface
     */
    public function getById(int $entityId): PetInterface;

    /**
     * @param PetInterface $pet
     * @throws CouldNotSaveException
     * @return int
     */
    public function save(PetInterface $pet): int;
}
