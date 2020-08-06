<?php
/**
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetType\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class PetTypeResourceModel extends AbstractDb
{

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init('pet_type_table', 'entity_id');
    }
}
