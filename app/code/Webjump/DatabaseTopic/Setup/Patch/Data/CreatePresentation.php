<?php
/**
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\DatabaseTopic\Setup\Patch\Data;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Api\Data\CustomerInterfaceFactory;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Webjump\DatabaseTopic\Api\Data\PetInterface;
use Webjump\DatabaseTopic\Api\Data\PetInterfaceFactory;
use Webjump\DatabaseTopic\Api\PetRepositoryInterface;
use Webjump\DatabaseTopic\Model\Pet;

/**
 * @SuppressWarnings(PHPMD)
 * @codeCoverageIgnore
 */
class CreatePresentation implements DataPatchInterface
{

    /**
     * @var PetInterfaceFactory
     */
    private $petFactory;

    /**
     * @var PetRepositoryInterface
     */
    private $petRepository;

    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * @var CustomerInterfaceFactory
     */
    private $customerFactory;

    /**
     * CreatePets constructor.
     * @param PetInterfaceFactory $petFactory
     * @param PetRepositoryInterface $petRepository
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param CustomerRepositoryInterface $customerRepository
     * @param CustomerInterfaceFactory $customerFactory
     */
    public function __construct(
        PetInterfaceFactory $petFactory,
        PetRepositoryInterface $petRepository,
        ModuleDataSetupInterface $moduleDataSetup,
        CustomerRepositoryInterface $customerRepository,
        CustomerInterfaceFactory $customerFactory
    ) {
        $this->petFactory = $petFactory;
        $this->petRepository = $petRepository;
        $this->moduleDataSetup = $moduleDataSetup;
        $this->customerRepository = $customerRepository;
        $this->customerFactory = $customerFactory;
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
     * @throws LocalizedException
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $customer = $this->saveCustomer();
        $pet = [
            PetInterface::PET_NAME => 'Rex',
            PetInterface::PET_OWNER => $customer->getFirstname(),
            PetInterface::OWNER_TELEPHONE => '11 99999-9999',
            PetInterface::OWNER_ID => $customer->getId(),
        ];

        $this->savePet($pet);

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * @return CustomerInterface
     * @throws LocalizedException
     */
    public function saveCustomer(): CustomerInterface
    {
        /** @var CustomerInterface $customer */
        $customer = $this->customerFactory->create();
        $customer->setFirstname('Deocleciano')
            ->setLastname('Junior')
            ->setEmail('deocleciano@test.com');
        return $this->customerRepository->save($customer);
    }

    /**
     * @param array $data
     * @throws CouldNotSaveException
     */
    public function savePet(array $data): void
    {
        $pet = $this->petFactory->create();
        $pet->setData($data);
        $this->petRepository->save($pet);
    }

    /**
     * @param CustomerInterface $customer
     * @return array
     */
    public function getPetsData(CustomerInterface $customer): array
    {
        return [
            [
                PetInterface::PET_NAME => 'Rex',
                PetInterface::PET_OWNER => $customer->getFirstname(),
                PetInterface::OWNER_TELEPHONE => '11 99999-9999',
                PetInterface::OWNER_ID => $customer->getId(),
            ]
        ];
    }
}
