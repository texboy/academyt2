<?php
/*
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetGraphQl\Api;

interface PetKindArrayProcessorInterface
{
    /**
     * @param array $petKindInput
     * @return array
     */
    public function processArray(array $petKindInput): array;
}
