<?php
/*
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetGraphQl\Model;

use Webjump\PetGraphQl\Api\PetKindArrayProcessorInterface;

class PetKindArrayProcessor implements PetKindArrayProcessorInterface
{

    /**
     * @param array $petKindInput
     * @return array
     */
    public function processArray(array $petKindInput): array
    {
        $data = [];
        if (isset($petKindInput['input'])) {
            if (!isset($petKindInput['input']['description'])) {
                $petKindInput['input']['description'] = "";
            }
            $data['general'] = $petKindInput['input'];
        }
        return $data;
    }
}
