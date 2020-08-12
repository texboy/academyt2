<?php
/*
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetCrud\Model;

use Webjump\PetCrud\Api\PetTypeSaveProcessorInterface;
use Webjump\PetType\Api\Data\PetTypeInterfaceFactory;
use Webjump\PetType\Api\PetTypeRepositoryInterface;

class PetTypeSaveProcessor implements PetTypeSaveProcessorInterface
{
    /**
     * @var PetTypeInterfaceFactory
     */
    private $petTypeFactory;

    /**
     * @var PetTypeRepositoryInterface
     */
    private $petTypeRepository;

    /**
     * PetTypeSaveProcessor constructor.
     * @param PetTypeInterfaceFactory $petTypeFactory
     * @param PetTypeRepositoryInterface $petTypeRepository
     */
    public function __construct(PetTypeInterfaceFactory $petTypeFactory, PetTypeRepositoryInterface $petTypeRepository)
    {
        $this->petTypeFactory = $petTypeFactory;
        $this->petTypeRepository = $petTypeRepository;
    }

    /**
     * @inheritDoc
     */
    public function process(array $requestData): void
    {
        if (isset($requestData['general']['entity_id'])) {
            $petType = $this->petTypeRepository->getById((int)$requestData['general']['entity_id']);
        } else {
            $petType = $this->petTypeFactory->create();
        }
        $petType->setPetType($requestData['general']['pet_type']);
        $this->petTypeRepository->save($petType);
    }
}
