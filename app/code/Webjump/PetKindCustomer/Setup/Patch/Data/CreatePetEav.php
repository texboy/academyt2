<?php
/**
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetKindCustomer\Setup\Patch\Data;

use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetup;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Eav\Model\AttributeRepository;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

/**
 * @codeCoverageIgnore
 */
class CreatePetEav implements DataPatchInterface
{

    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var CustomerSetupFactory
     */
    private $customerSetupFactory;

    /**
     * @var AttributeRepository
     */
    private $attributeRepository;

    /**
     * CreatePetEav constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param CustomerSetupFactory $customerSetupFactory
     * @param AttributeRepository $attributeRepository
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CustomerSetupFactory $customerSetupFactory,
        AttributeRepository $attributeRepository
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeRepository = $attributeRepository;
    }


    /**
     * @inheritDoc
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * @inheritDoc
     * @throws AlreadyExistsException|LocalizedException|\Zend_Validate_Exception
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        /** @var CustomerSetup $customerSetup */
        $customerSetup = $this->customerSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $customerSetup->addAttribute(Customer::ENTITY, 'pet_name', [
            'type' => 'varchar',
            'label' => 'Pet Name',
            'input' => 'text',
            'required' => true,
            'visible' => true,
            'source' => '',
            'backend' => '',
            'user_defined' => false,
            'is_user_defined' => false,
            'sort_order' => 1000,
            'is_used_in_grid' => false,
            'is_visible_in_grid' => false,
            'is_filterable_in_grid' => false,
            'is_searchable_in_grid' => false,
            'position' => 1000,
            'default' => 0,
            'system' => 0,
        ]);

        $attribute = $this->attributeRepository->get(Customer::ENTITY, 'pet_name');
        $this->moduleDataSetup->getConnection()
            ->insertOnDuplicate(
                $this->moduleDataSetup->getTable('customer_form_attribute'),
                [
                    ['form_code' => 'customer_account_edit', 'attribute_id' => $attribute->getId()]
                ]
            );
        $this->moduleDataSetup->getConnection()->endSetup();
    }
}
