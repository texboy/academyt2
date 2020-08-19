<?php
/**
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetKindCustomer\Model;

use Magento\Framework\Model\AbstractModel;
use Webjump\PetKind\Model\ResourceModel\PetKindResourceModel;
use Webjump\PetKindCustomer\Api\Data\PetKindCustomerInterface;

/**
 * @codeCoverageIgnore
 */
class PetKindCustomer extends AbstractModel implements PetKindCustomerInterface
{
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(PetKindResourceModel::class);
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
    public function getPetKindId(): ?int
    {
        return (int) $this->getData(self::PET_KIND_ID);
    }

    /**
     * @inheritDoc
     */
    public function setPetKindId($petKindId): void
    {
        $this->setData(self::PET_KIND_ID, (int) $petKindId);
    }

    /**
     * @inheritDoc
     */
    public function getCustomerId(): ?int
    {
        return (int) $this->getData(self::CUSTOMER_ID);
    }

    /**
     * @inheritDoc
     */
    public function setCustomerId($customerId): void
    {
        $this->setData(self::CUSTOMER_ID, (int) $customerId);
    }

    public function getCreatedAt(): ?string
    {
        return $this->getData(self::CREATED_AT);
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->setData(self::CREATED_AT, $createdAt);
    }
}
