<?php
/**
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetKindCustomer\Model\ResourceModel\PetKindCustomer;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Webjump\PetKindCustomer\Model\PetKindCustomer;
use Webjump\PetKindCustomer\Model\ResourceModel\PetKindCustomerResourceModel;

/**
 * @codeCoverageIgnore
 */
class Collection extends AbstractCollection
{
    /**
     * Event prefix
     *
     * @var string
     */
    protected $_eventPrefix = 'pet_kind_customer';

    /**
     * Event object name
     *
     * @var string
     */
    protected $_eventObject = 'pet_kind_customer';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(PetKindCustomer::class, PetKindCustomerResourceModel::class);
    }
}
