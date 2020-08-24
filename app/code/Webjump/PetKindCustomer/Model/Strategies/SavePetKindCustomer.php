<?php
/*
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetKindCustomer\Model\Strategies;

use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\App\RequestInterface;
use Webjump\PetKindCustomer\Api\PetKindCustomerRepositoryInterface;
use Webjump\PetKindCustomer\Api\SaveStrategyInterface;

class SavePetKindCustomer implements SaveStrategyInterface
{

    /**
     * @var PetKindCustomerRepositoryInterface
     */
    private $petKindCustomerRepository;

    /**
     * @var CustomerSession
     */
    private $customerSession;

    /**
     * SavePetKindCustomer constructor.
     * @param PetKindCustomerRepositoryInterface $petKindCustomerRepository
     * @param CustomerSession $customerSession
     */
    public function __construct(
        PetKindCustomerRepositoryInterface $petKindCustomerRepository,
        CustomerSession $customerSession
    ) {
        $this->petKindCustomerRepository = $petKindCustomerRepository;
        $this->customerSession = $customerSession;
    }


    /**
     * @inheritDoc
     */
    public function execute(RequestInterface $request): void
    {
        $petKindId = $request->getPost()->get('pet_kind');
        $customerId = $this->customerSession->getId();
        $petKindCustomer = $this->petKindCustomerRepository->getByCustomerId((int) $customerId);
        if ($petKindId !== null) {
            $petKindCustomer->setPetKindId((int) $petKindId);
            $petKindCustomer->setCustomerId((int) $customerId);
            $this->petKindCustomerRepository->save($petKindCustomer);
        }
    }
}
