<?php
/**
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\DatabaseTopic\Model\ResourceModel\Pet;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Webjump\DatabaseTopic\Model\Pet;
use Webjump\DatabaseTopic\Model\ResourceModel\PetResourceModel;

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
    protected $_eventPrefix = 'pet_table';

    /**
     * Event object name
     *
     * @var string
     */
    protected $_eventObject = 'pet_table';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(Pet::class, PetResourceModel::class);
    }
}
