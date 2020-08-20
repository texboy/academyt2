<?php
/*
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetKindCustomer\Model\Strategies;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\App\RequestInterface;
use Webjump\PetKindCustomer\Api\PetKindCustomerRepositoryInterface;
use Webjump\PetKindCustomer\Api\SaveStrategyInterface;

class SavePetKindCustomer implements SaveStrategyInterface
{
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var PetKindCustomerRepositoryInterface
     */
    private $petKindCustomerRepository;

    /**
     * SavePetKindCustomer constructor.
     * @param RequestInterface $request
     * @param PetKindCustomerRepositoryInterface $petKindCustomerRepository
     */
    public function __construct(
        RequestInterface $request,
        PetKindCustomerRepositoryInterface $petKindCustomerRepository
    ) {
        $this->request = $request;
        $this->petKindCustomerRepository = $petKindCustomerRepository;
    }

    /**
     * @inheritDoc
     */
    public function execute(CustomerInterface $customer): void
    {
        $petKindId = $this->request->getPost()->get('pet_kind');
        $petKindCustomer = $this->petKindCustomerRepository->getByCustomerId((int)$customer->getId());
        if ($petKindId !== null) {
            $petKindCustomer->setPetKindId((int) $petKindId);
            $petKindCustomer->setCustomerId((int)$customer->getId());
            $this->petKindCustomerRepository->save($petKindCustomer);
        }
    }
}
