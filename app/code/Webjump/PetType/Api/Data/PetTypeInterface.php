<?php
/**
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetType\Api\Data;

interface PetTypeInterface
{
    const ENTITY_ID = 'entity_id';
    const PET_TYPE = 'pet_type';

    /**
     * @return int|null
     */
    public function getEntityId(): ?int;

    /**
     * @param int $entityId
     * @return void
     */
    public function setEntityId(int $entityId): void;

    /**
     * @return string|null
     */
    public function getPetType(): ?string;

    /**
     * @param string $petType
     * @return void
     */
    public function setPetType(string $petType): void;
}
