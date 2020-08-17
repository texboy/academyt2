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

class PetKindResolver implements ResolverInterface
{
    /**
     * @var PetKindRepositoryInterface
     */
    private $petKindRepository;

    /**
     * PetKindResolver constructor.
     * @param PetKindRepositoryInterface $petKindRepository
     */
    public function __construct(PetKindRepositoryInterface $petKindRepository)
    {
        $this->petKindRepository = $petKindRepository;
    }

    /**
     * @inheritDoc
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        return $this->petKindRepository->getById((int) $args['entity_id']);
    }
}
