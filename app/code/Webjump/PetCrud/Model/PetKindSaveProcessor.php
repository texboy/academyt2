<?php
/*
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetCrud\Model;

use Webjump\PetCrud\Api\PetKindSaveProcessorInterface;
use Webjump\PetKind\Api\Data\PetKindInterfaceFactory;
use Webjump\PetKind\Api\PetKindRepositoryInterface;

class PetKindSaveProcessor implements PetKindSaveProcessorInterface
{
    /**
     * @var PetKindInterfaceFactory
     */
    private $petKindFactory;

    /**
     * @var PetKindRepositoryInterface
     */
    private $petKindRepository;

    /**
     * PetKindSaveProcessor constructor.
     * @param PetKindInterfaceFactory $petKindFactory
     * @param PetKindRepositoryInterface $petKindRepository
     */
    public function __construct(
        PetKindInterfaceFactory $petKindFactory,
        PetKindRepositoryInterface $petKindRepository
    ) {
        $this->petKindFactory = $petKindFactory;
        $this->petKindRepository = $petKindRepository;
    }


    /**
     * @inheritDoc
     */
    public function process(array $requestData): void
    {
        if (isset($requestData['general']['entity_id'])) {
            $petKind = $this->petKindRepository->getById((int)$requestData['general']['entity_id']);
        } else {
            $petKind = $this->petKindFactory->create();
        }
        $petKind->setName($requestData['general']['name']);
        $petKind->setDescription($requestData['general']['description']);

        $this->petKindRepository->save($petKind);
    }
}
