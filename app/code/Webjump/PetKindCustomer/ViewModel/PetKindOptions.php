<?php
/*
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetKindCustomer\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Webjump\PetKind\Api\PetKindRepositoryInterface;

class PetKindOptions implements ArgumentInterface
{
    /**
     * @var PetKindRepositoryInterface
     */
    private $petKindRepository;

    /**
     * PetKindOptions constructor.
     * @param PetKindRepositoryInterface $petKindRepository
     */
    public function __construct(PetKindRepositoryInterface $petKindRepository)
    {
        $this->petKindRepository = $petKindRepository;
    }

    /**
     * @param int|null $selectedIndex
     * @return array
     */
    public function getPetKindOptions(int $selectedIndex = null): array
    {
        $petKinds = $this->petKindRepository->getList()->getItems();
        $options[] = ["value" => "", "label" => "", "selected" => false];
        foreach ($petKinds as $petKind) {
            $selected = false;
            if ($petKind->getEntityId() == $selectedIndex) {
                $selected = true;
            }
            $options[] = [
                "value" => $petKind->getEntityId(),
                "label" => $petKind->getName(),
                "selected" => $selected
            ];
        }
        return $options;
    }
}
