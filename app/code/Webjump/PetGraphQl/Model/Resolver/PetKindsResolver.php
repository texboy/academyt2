<?php
/*
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetGraphQl\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Webjump\PetKind\Api\PetKindRepositoryInterface;

class PetKindsResolver implements ResolverInterface
{
    /**
     * @var PetKindRepositoryInterface
     */
    private $petKindRepository;

    /**
     * PetKindsResolver constructor.
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
        $petKinds = $this->petKindRepository->getList();
        return $petKinds->getItems();
    }
}
