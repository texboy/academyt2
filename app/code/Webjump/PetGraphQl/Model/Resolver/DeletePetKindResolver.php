<?php
/*
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetGraphQl\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Query\Resolver\Value;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\Reflection\DataObjectProcessor;
use Webjump\PetKind\Api\Data\PetKindInterface;
use Webjump\PetKind\Api\PetKindRepositoryInterface;

class DeletePetKindResolver implements ResolverInterface
{
    /**
     * @var PetKindRepositoryInterface
     */
    private $petKindRepository;

    /**
     * @var DataObjectProcessor
     */
    private $dataProcessor;

    /**
     * PetKindsResolver constructor.
     * @param PetKindRepositoryInterface $petKindRepository
     * @param DataObjectProcessor $dataProcessor
     */
    public function __construct(PetKindRepositoryInterface $petKindRepository, DataObjectProcessor $dataProcessor)
    {
        $this->petKindRepository = $petKindRepository;
        $this->dataProcessor = $dataProcessor;
    }

    /**
     * @inheritDoc
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        return $this->petKindRepository->deleteById((int) $args['entity_id']);
    }
}
