<?php
/*
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetKindCustomer\Api;

use Magento\Framework\Api\SearchResultsInterface;

interface PetKindCustomerSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return \Webjump\PetKindCustomer\Api\Data\PetKindCustomerInterface[]
     */
    public function getItems();

    /**
     * @param array $items
     * @return \Webjump\PetKindCustomer\Api\Data\PetKindCustomerInterface[]
     */
    public function setItems(array $items);
}
