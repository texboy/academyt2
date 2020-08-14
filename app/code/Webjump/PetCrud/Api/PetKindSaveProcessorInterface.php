<?php
/*
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetCrud\Api;

use Magento\Framework\Exception\CouldNotSaveException;

interface PetKindSaveProcessorInterface
{
    /**
     * @param array $requestData
     * @throws CouldNotSaveException
     * @return void
     */
    public function process(array $requestData): void;
}
