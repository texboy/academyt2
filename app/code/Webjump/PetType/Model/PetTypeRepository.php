<?php
/**
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetType\Model;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Webjump\PetType\Api\Data\PetTypeInterface;
use Webjump\PetType\Api\PetTypeRepositoryInterface;
use Webjump\PetType\Api\Data\PetTypeInterfaceFactory;
use Webjump\PetType\Model\ResourceModel\PetType\Collection;
use Webjump\PetType\Model\ResourceModel\PetType\CollectionFactory;
use Webjump\PetType\Model\ResourceModel\PetTypeResourceModel;

class PetTypeRepository implements PetTypeRepositoryInterface
{

    /**
     * @var PetTypeInterfaceFactory
     */
    private $petTypeFactory;

    /**
     * @var PetTypeResourceModel
     */
    private $petTypeResourceModel;

    /**
     * @var CollectionFactory
     */
    private $petTypeCollectionFactory;

    /**
     * PetTypeRepository constructor.
     * @param PetTypeInterfaceFactory $petTypeFactory
     * @param PetTypeResourceModel $petTypeResourceModel
     * @param CollectionFactory $petTypeCollectionFactory
     */
    public function __construct(
        PetTypeInterfaceFactory $petTypeFactory,
        PetTypeResourceModel $petTypeResourceModel,
        CollectionFactory $petTypeCollectionFactory
    ) {
        $this->petTypeFactory = $petTypeFactory;
        $this->petTypeResourceModel = $petTypeResourceModel;
        $this->petTypeCollectionFactory = $petTypeCollectionFactory;
    }


    /**
     * @inheritDoc
     */
    public function getById(int $entityId): PetTypeInterface
    {
        /** @var PetTypeInterface $petType */
        $petType = $this->petTypeFactory->create();
        $this->petTypeResourceModel->load($petType, $entityId);
        return $petType;
    }

    /**
     * @inheritDoc
     */
    public function getList(): array
    {
        /** @var Collection $petTypeCollection */
        $petTypeCollection = $this->petTypeCollectionFactory->create();
        return $petTypeCollection->getItems();
    }

    /**
     * @inheritDoc
     */
    public function save(PetTypeInterface $petType): int
    {
        try {
            $this->petTypeResourceModel->save($petType);
            return (int) $petType->getEntityId();
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__('Could not save pet type'), $e);
        }
    }

    public function deleteById(int $entityId): bool
    {
        try {
            $this->petTypeResourceModel->delete($this->getById($entityId));
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__('Could not delete pet type'), $e);
        }
        return true;
    }
}
