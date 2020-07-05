<?php
/**
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\DatabaseTopic\Block\Pets;

use Magento\Framework\View\Element\Template;
use Webjump\DatabaseTopic\Api\PetRepositoryInterface;

class Show extends Template
{
    /**
     * @var PetRepositoryInterface
     */
    private $petRepository;

    /**
     * @param PetRepositoryInterface $petRepository
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        PetRepositoryInterface $petRepository,
        Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->petRepository = $petRepository;
    }

    /**
     * @return array
     */
    public function getAllPets(): array
    {
        return $this->petRepository->getList();
    }
}
