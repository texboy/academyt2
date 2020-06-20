<?php
/**
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\DatabaseTopic\Model;

use Magento\Framework\Model\AbstractModel;
use Webjump\DatabaseTopic\Api\Data\PetInterface;
use Webjump\DatabaseTopic\Model\ResourceModel\PetResourceModel;

class Pet extends AbstractModel implements PetInterface
{
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(PetResourceModel::class);
    }

    /**
     * @inheritDoc
     */
    public function getEntityId(): ?int
    {
        return (int) $this->getData(self::ENTITY_ID);
    }

    /**
     * @inheritDoc
     */
    public function setEntityId($entityId): void
    {
        $this->setData(self::ENTITY_ID, (int) $entityId);
    }

    /**
     * @inheritDoc
     */
    public function getPetName(): ?string
    {
        return $this->getData(self::PET_NAME);
    }

    /**
     * @inheritDoc
     */
    public function setPetName(string $petName): void
    {
        $this->setData(self::PET_NAME, $petName);
    }

    /**
     * @inheritDoc
     */
    public function getPetOwner(): ?string
    {
        return $this->getData(self::PET_OWNER);
    }

    /**
     * @inheritDoc
     */
    public function setPetOwner(string $petOwner): void
    {
        $this->setData(self::PET_OWNER, $petOwner);
    }

    /**
     * @inheritDoc
     */
    public function getOwnerTelephone(): ?string
    {
        return $this->getData(self::OWNER_TELEPHONE);
    }

    /**
     * @inheritDoc
     */
    public function setOwnerTelephone(string $ownerTelephone): void
    {
        $this->setData(self::OWNER_TELEPHONE, $ownerTelephone);
    }

    /**
     * @inheritDoc
     */
    public function getOwnerId(): ?int
    {
        return $this->getData(self::OWNER_ID);
    }

    /**
     * @inheritDoc
     */
    public function setOwnerId(int $ownerId): void
    {
        $this->setData(self::OWNER_ID, $ownerId);
    }

    /**
     * @inheritDoc
     */
    public function getCreatedAt(): ?string
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * @inheritDoc
     */
    public function setCreatedAt(string $createdAt): void
    {
        $this->setData(self::CREATED_AT, $createdAt);
    }
}
