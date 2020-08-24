<?php
/*
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetKindCustomer\Plugin;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Api\Data\CustomerSearchResultsInterface;
use Webjump\PetKindCustomer\Api\PetKindCustomerRepositoryInterface;

class CustomerPetKindCustomerExtensionAttributePlugin
{
    /**
     * @var PetKindCustomerRepositoryInterface
     */
    private $petKindCustomerRepository;

    /**
     * CustomerPetKindCustomerExtensionAttributePlugin constructor.
     * @param PetKindCustomerRepositoryInterface $petKindCustomerRepository
     */
    public function __construct(PetKindCustomerRepositoryInterface $petKindCustomerRepository)
    {
        $this->petKindCustomerRepository = $petKindCustomerRepository;
    }

    /**
     * @param CustomerRepositoryInterface $subject
     * @@param CustomerInterface $result
     * @return CustomerInterface
     */
    public function afterGet(CustomerRepositoryInterface $subject, CustomerInterface $result): CustomerInterface
    {
        $petKindCustomer = $this->petKindCustomerRepository->getByCustomerId((int) $result->getId());
        if ($petKindCustomer->getEntityId() !== 0) {
            $result->getExtensionAttributes()->setPetKindCustomer($petKindCustomer);
        }
        return $result;
    }

    /**
     * @param CustomerRepositoryInterface $subject
     * @@param CustomerInterface $result
     * @return CustomerInterface
     */
    public function afterGetById(CustomerRepositoryInterface $subject, CustomerInterface $result): CustomerInterface
    {
        $petKindCustomer = $this->petKindCustomerRepository->getByCustomerId((int) $result->getId());
        if ($petKindCustomer->getEntityId() !== 0) {
            $result->getExtensionAttributes()->setPetKindCustomer($petKindCustomer);
        }
        return $result;
    }

    /**
     * @param CustomerRepositoryInterface $subject
     * @param CustomerSearchResultsInterface $result
     * @return CustomerSearchResultsInterface
     */
    public function afterGetList(
        CustomerRepositoryInterface $subject,
        CustomerSearchResultsInterface $result
    ): CustomerSearchResultsInterface {
        $customers = [];
        foreach ($result->getItems() as $customer) {
            $petKindCustomer = $this->petKindCustomerRepository->getByCustomerId((int) $customer->getId());
            if ($petKindCustomer->getEntityId() !== 0) {
                $customer->getExtensionAttributes()->setPetKindCustomer($petKindCustomer);
            }
            $customers[] = $customer;
        }
        $result->setItems($customers);
        return $result;
    }
}
