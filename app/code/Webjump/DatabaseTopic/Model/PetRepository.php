<?php
/**
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\DatabaseTopic\Model;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Webjump\DatabaseTopic\Api\Data\PetInterface;
use Webjump\DatabaseTopic\Api\PetRepositoryInterface;
use Webjump\DatabaseTopic\Api\Data\PetInterfaceFactory;
use Webjump\DatabaseTopic\Model\ResourceModel\PetResourceModel;

class PetRepository implements PetRepositoryInterface
{

    /**
     * @var PetInterfaceFactory
     */
    private $petFactory;

    /**
     * @var PetResourceModel
     */
    private $petResourceModel;

    /**
     * PetRepository constructor.
     * @param PetInterfaceFactory $petFactory
     * @param PetResourceModel $petResourceModel
     */
    public function __construct(
        PetInterfaceFactory $petFactory,
        PetResourceModel $petResourceModel
    ) {
        $this->petFactory = $petFactory;
        $this->petResourceModel = $petResourceModel;
    }

    /**
     * @inheritDoc
     */
    public function getById(int $entityId): PetInterface
    {
        /** @var PetInterface $pet */
        $pet = $this->petFactory->create();
        $this->petResourceModel->load($pet, $entityId);
        if (!$pet->getEntityId()) {
            throw new NoSuchEntityException(
                __('Pet with "%1" ID doesn\'t exist. Verify the ID and try again.', $entityId)
            );
        }
        return $pet;
    }

    /**
     * @inheritDoc
     */
    public function save(PetInterface $pet): int
    {
        try {
            $this->petResourceModel->save($pet);
            return (int) $pet->getEntityId();
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__('Could not save pet'), $e);
        }
    }
}
