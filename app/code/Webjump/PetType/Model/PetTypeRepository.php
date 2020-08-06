<?php
/**
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetType\Model;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
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
        if (!$petType->getEntityId()) {
            throw new NoSuchEntityException(
                __('Pet type with "%1" ID doesn\'t exist. Verify the ID and try again.', $entityId)
            );
        }
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
}
