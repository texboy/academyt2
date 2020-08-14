<?php
/*
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetKind\Api;

use Magento\Framework\Api\SearchResultsInterface;

interface PetKindSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return \Webjump\PetKind\Api\Data\PetKindInterface[]
     */
    public function getItems();

    /**
     * @param array $items
     * @return \Webjump\PetKind\Api\Data\PetKindInterface[]
     */
    public function setItems(array $items);
}
