<?php
/**
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetKindCustomer\Api\Data;

interface PetKindCustomerInterface
{
    const ENTITY_ID = 'entity_id';
    const PET_KIND_ID = 'pet_kind_id';
    const CUSTOMER_ID = 'customer_id';
    const CREATED_AT = 'created_at';

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
     * @return int|null
     */
    public function getPetKindId(): ?int;

    /**
     * @param int $petKindId
     * @return void
     */
    public function setPetKindId(int $petKindId): void;

    /**
     * @return int|null
     */
    public function getCustomerId(): ?int;

    /**
     * @param int $customerId
     * @return void
     */
    public function setCustomerId(int $customerId): void;

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string;

    /**
     * @param string $createdAt
     * @return void
     */
    public function setCreatedAt(string $createdAt): void;
}
