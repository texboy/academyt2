<?php
/*
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetKindCustomer\ViewModel;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class CustomerData implements ArgumentInterface
{
    /**
     * @var Session
     */
    private $customerSession;

    /**
     * CustomerData constructor.
     * @param Session $customerSession
     */
    public function __construct(Session $customerSession)
    {
        $this->customerSession = $customerSession;
    }

    /**
     * @return CustomerInterface|null
     */
    public function getCustomerData(): ?CustomerInterface
    {
        try {
            return $this->customerSession->getCustomerData();
        } catch (NoSuchEntityException | LocalizedException$e) {
            return null;
        }
    }

    /**
     * @return int|null
     */
    public function getPetKindSelectedId(): ?int
    {
        $petKindId = null;
        try {
            $petKindCustomer = $this->customerSession
                ->getCustomerData()
                ->getExtensionAttributes()
                ->getPetKindCustomer();
            if ($petKindCustomer !== null) {
                $petKindId = $petKindCustomer->getPetKindId();
            }
            return $petKindId;
        } catch (NoSuchEntityException | LocalizedException$e) {
            return $petKindId;
        }
    }

    /**
     * @return string
     */
    public function getPetName(): string
    {
        $petName = "";
        $customer = $this->getCustomerData();
        if ($customer !== null) {
            $value = $customer->getCustomAttribute('pet_name')->getValue();
            if ($value != false) {
                $petName = $value;
            }
        }
        return $petName;
    }
}
