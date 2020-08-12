<?php
/**
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetType\Model;

use Magento\Framework\Model\AbstractModel;
use Webjump\PetType\Model\ResourceModel\PetTypeResourceModel;
use Webjump\PetType\Api\Data\PetTypeInterface;

/**
 * @codeCoverageIgnore
 */
class PetType extends AbstractModel implements PetTypeInterface
{
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(PetTypeResourceModel::class);
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
    public function getPetType(): ?string
    {
        return $this->getData(self::PET_TYPE);
    }

    /**
     * @inheritDoc
     */
    public function setPetType(string $petType): void
    {
        $this->setData(self::PET_TYPE, $petType);
    }
}
