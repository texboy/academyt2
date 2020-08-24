<?php
/*
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetKindCustomer\Test\Unit\Model\Strategies;

use Laminas\Stdlib\Parameters;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use Webjump\PetKindCustomer\Api\Data\PetKindCustomerInterface;
use Webjump\PetKindCustomer\Api\PetKindCustomerRepositoryInterface;
use Webjump\PetKindCustomer\Model\Strategies\SavePetKindCustomer as Strategy;

class SavePetKindCustomerTest extends TestCase
{
    /**
     * @var CustomerSession
     */
    private $customerSession;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var Parameters
     */
    private $parameters;

    /**
     * @var PetKindCustomerRepositoryInterface
     */
    private $petKindCustomerRepository;

    /**
     * @var PetKindCustomerInterface
     */
    private $petKindCustomer;

    /**
     * @var Strategy
     */
    private $strategy;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $objectManager = new ObjectManager($this);
        $this->request = $this->getMockBuilder(RequestInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['getPost'])
            ->getMockForAbstractClass();
        $this->parameters = $this->createMock(Parameters::class);
        $this->petKindCustomerRepository = $this->createMock(PetKindCustomerRepositoryInterface::class);
        $this->petKindCustomer = $this->createMock(PetKindCustomerInterface::class);
        $this->customerSession = $this->createMock(CustomerSession::class);

        $this->strategy = $objectManager->getObject(Strategy::class, [
            'petKindCustomerRepository' => $this->petKindCustomerRepository,
            'customerSession' => $this->customerSession
        ]);
    }

    /**
     * @return void
     * @throws NoSuchEntityException|CouldNotSaveException
     */
    public function testExecuteShouldSavePetKind(): void
    {
        $customerId = '1';
        $petKindId = '1';

        $this->customerSession->expects($this->once())
            ->method('getId')
            ->willReturn($customerId);

        $this->petKindCustomerRepository->expects($this->once())
            ->method('getByCustomerId')
            ->willReturn($this->petKindCustomer);

        $this->request->expects($this->once())
            ->method('getPost')
            ->willReturn($this->parameters);

        $this->parameters->expects($this->once())
            ->method('get')
            ->willReturn($petKindId);

        $this->strategy->execute($this->request);
    }
}
