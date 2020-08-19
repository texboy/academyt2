<?php
/*
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetGraphQl\Model\Resolver;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Webjump\PetCrud\Api\PetKindSaveProcessorInterface;
use Webjump\PetGraphQl\Api\PetKindArrayProcessorInterface;

class EditPetKindResolver implements ResolverInterface
{
    /**
     * @var PetKindArrayProcessorInterface
     */
    private $arrayProcessor;

    /**
     * @var PetKindSaveProcessorInterface
     */
    private $saveProcessor;

    /**
     * SavePetKindResolver constructor.
     * @param PetKindArrayProcessorInterface $arrayProcessor
     * @param PetKindSaveProcessorInterface $saveProcessor
     */
    public function __construct(
        PetKindArrayProcessorInterface $arrayProcessor,
        PetKindSaveProcessorInterface $saveProcessor
    ) {
        $this->arrayProcessor = $arrayProcessor;
        $this->saveProcessor = $saveProcessor;
    }

    /**
     * @inheritDoc
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        try {
            $data = $this->arrayProcessor->processArray($args);
            $this->saveProcessor->process($data);
        } catch (CouldNotSaveException $e) {
            throw new GraphQlInputException(__($e));
        }
        return true;
    }
}
