<?php
/**
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\DatabaseTopic\Api\Data;


interface PetInterface
{
    const ENTITY_ID = 'entity_id';
    const PET_NAME = 'pet_name';
    const PET_OWNER = 'pet_owner';
    const OWNER_TELEPHONE = 'owner_telephone';
    const OWNER_ID = 'owner_id';
    const CREATED_AT = 'created_at';

    /**
     * Return type is causing a conflict with abstract model. Removed the type for now
     *
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
    public function getPetName(): ?string;

    /**
     * @param string $petName
     * @return void
     */
    public function setPetName(string $petName): void;

    /**
     * @return string|null
     */
    public function getPetOwner(): ?string;

    /**
     * @param string $petOwner
     * @return void
     */
    public function setPetOwner(string $petOwner): void;

    /**
     * @return string|null
     */
    public function getOwnerTelephone(): ?string;

    /**
     * @param string $ownerTelephone
     * @return void
     */
    public function setOwnerTelephone(string $ownerTelephone): void;

    /**
     * @return int|null
     */
    public function getOwnerId(): ?int;

    /**
     * @param int $ownerId
     * @return void
     */
    public function setOwnerId(int $ownerId): void;

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
