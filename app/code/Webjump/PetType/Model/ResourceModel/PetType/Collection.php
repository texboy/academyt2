<?php
/**
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetType\Model\ResourceModel\PetType;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Webjump\PetType\Model\PetType;
use Webjump\PetType\Model\ResourceModel\PetTypeResourceModel;

class Collection extends AbstractCollection
{
    /**
     * Event prefix
     *
     * @var string
     */
    protected $_eventPrefix = 'pet_type_table';

    /**
     * Event object name
     *
     * @var string
     */
    protected $_eventObject = 'pet_type';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(PetType::class, PetTypeResourceModel::class);
    }
}
