<?php
/**
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetKind\Model;

use Magento\Framework\Model\AbstractModel;
use Webjump\PetKind\Model\ResourceModel\PetKindResourceModel;
use Webjump\PetKind\Api\Data\PetKindInterface;

/**
 * @codeCoverageIgnore
 */
class PetKind extends AbstractModel implements PetKindInterface
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

    public function getName(): ?string
    {
        return $this->getData(self::NAME);
    }

    public function setName(string $name): void
    {
        $this->setData(self::NAME, $name);
    }

    public function getDescription(): ?string
    {
        return $this->getData(self::DESCRIPTION);
    }

    public function setDescription(string $description): void
    {
        $this->setData(self::DESCRIPTION, $description);
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
