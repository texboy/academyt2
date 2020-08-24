<?php
/*
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetKindCustomer\ViewModel\Header;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Phrase;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Webjump\PetKind\Api\PetKindRepositoryInterface;

class PetHeaderMessage implements ArgumentInterface
{
    const CAN_SHOW_PET_CONF_PATH = 'petkindcustomer/general/enabled';

    /**
     * @var Session
     */
    private $customerSession;

    /**
     * @var PetKindRepositoryInterface
     */
    private $petKindRepository;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * PetHeaderMessage constructor.
     * @param Session $customerSession
     * @param PetKindRepositoryInterface $petKindRepository
     * @param StoreManagerInterface $storeManager
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        Session $customerSession,
        PetKindRepositoryInterface $petKindRepository,
        StoreManagerInterface $storeManager,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->customerSession = $customerSession;
        $this->petKindRepository = $petKindRepository;
        $this->storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
    }


    /**
     * @return Phrase
     */
    public function getPetNameAndKind(): Phrase
    {
        $message = __("Could not find a pet!");
        if ($this->customerSession->isLoggedIn() == true) {
            try {
                if ($this->canShowPet() === true) {
                    $customer = $this->customerSession->getCustomerData();
                    $petKindCustomer = $customer->getExtensionAttributes()->getPetKindCustomer();
                    if ($petKindCustomer !== null) {
                        $petKindId = $petKindCustomer->getPetKindId();
                        $petKind = $this->petKindRepository->getById($petKindId)->getName();
                        $petName = $customer->getCustomAttribute('pet_name')->getValue();
                        $message = __("You got a %1 named %2", $petKind, $petName);
                    }
                }
            } catch (NoSuchEntityException | LocalizedException $e) {
                $message = __("");
            }
        }
        return $message;
    }

    /**
     * @return bool
     */
    private function canShowPet(): bool
    {
        try {
            $storeId = $this->storeManager->getStore()->getId();
            return  (bool) $this->scopeConfig->getValue(
                self::CAN_SHOW_PET_CONF_PATH,
                ScopeInterface::SCOPE_STORE,
                $storeId
            );
        } catch (NoSuchEntityException $e) {
            return false;
        }
    }
}
