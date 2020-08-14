<?php
/**
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetKind\Model\ResourceModel\PetKind;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Webjump\PetKind\Model\PetKind;
use Webjump\PetKind\Model\ResourceModel\PetKindResourceModel;

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
    protected $_eventPrefix = 'pet_kind';

    /**
     * Event object name
     *
     * @var string
     */
    protected $_eventObject = 'pet_Kind';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(PetKind::class, PetKindResourceModel::class);
    }
}
