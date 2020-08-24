<?php
/*
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetKindCustomer\Test\Unit\Plugin;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerExtensionInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Api\Data\CustomerSearchResultsInterface;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use Webjump\PetKindCustomer\Api\Data\PetKindCustomerInterface;
use Webjump\PetKindCustomer\Api\PetKindCustomerRepositoryInterface;
use Webjump\PetKindCustomer\Plugin\CustomerPetKindCustomerExtensionAttributePlugin;
use Webjump\PetKindCustomer\Plugin\CustomerPetKindCustomerExtensionAttributePlugin as Plugin;

class CustomerPetKindCustomerExtensionAttributePluginTest extends TestCase
{

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * @var CustomerSearchResultsInterface
     */
    private $customerSearchResults;

    /**
     * @var CustomerInterface
     */
    private $customer;

    /**
     * @var CustomerExtensionInterface
     */
    private $extensionAttributes;

    /**
     * @var PetKindCustomerRepositoryInterface
     */
    private $petKindCustomerRepository;

    /**
     * @var PetKindCustomerInterface
     */
    private $petKindCustomer;

    /**
     * @var Plugin
     */
    private $plugin;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $objectManager = new ObjectManager($this);
        $this->customerRepository = $this->createMock(CustomerRepositoryInterface::class);
        $this->customerSearchResults = $this->createMock(CustomerSearchResultsInterface::class);
        $this->customer = $this->createMock(CustomerInterface::class);
        $this->extensionAttributes = $this->getMockBuilder(CustomerExtensionInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['getPetKindCustomer', 'setPetKindCustomer'])
            ->getMockForAbstractClass();
        $this->petKindCustomerRepository = $this->createMock(PetKindCustomerRepositoryInterface::class);
        $this->petKindCustomer = $this->createMock(PetKindCustomerInterface::class);
        $this->plugin = $objectManager->getObject(CustomerPetKindCustomerExtensionAttributePlugin::class, [
            'petKindCustomerRepository' => $this->petKindCustomerRepository
        ]);
    }

    /**
     * @return void
     */
    public function testAfterGetShouldReturnCustomerInterface(): void
    {
        $customerId = "1";
        $this->customer->expects($this->once())
            ->method('getId')
            ->willReturn($customerId);

        $this->petKindCustomerRepository->expects($this->once())
            ->method('getByCustomerId')
            ->willReturn($this->petKindCustomer);

        $this->customer->expects($this->once())
            ->method('getExtensionAttributes')
            ->willReturn($this->extensionAttributes);

        $this->extensionAttributes->expects($this->once())
            ->method('setPetKindCustomer')
            ->with($this->petKindCustomer);

        $result = $this->plugin->afterGet($this->customerRepository, $this->customer);
        $this->assertEquals($this->customer, $result);
    }

    /**
     * @return void
     */
    public function testAfterGetByIdShouldReturnCustomerInterface(): void
    {
        $customerId = "1";
        $this->customer->expects($this->once())
            ->method('getId')
            ->willReturn($customerId);

        $this->petKindCustomerRepository->expects($this->once())
            ->method('getByCustomerId')
            ->willReturn($this->petKindCustomer);

        $this->customer->expects($this->once())
            ->method('getExtensionAttributes')
            ->willReturn($this->extensionAttributes);

        $this->extensionAttributes->expects($this->once())
            ->method('setPetKindCustomer')
            ->with($this->petKindCustomer);

        $result = $this->plugin->afterGetById($this->customerRepository, $this->customer);
        $this->assertEquals($this->customer, $result);
    }

    /**
     * @return void
     */
    public function testAfterGetListShouldReturnSearchResults(): void
    {
        $customerId = "1";
        $this->customer->expects($this->once())
            ->method('getId')
            ->willReturn($customerId);

        $this->customerSearchResults->expects($this->once())
            ->method('getItems')
            ->willReturn([$this->customer]);

        $this->petKindCustomerRepository->expects($this->once())
            ->method('getByCustomerId')
            ->willReturn($this->petKindCustomer);

        $this->customer->expects($this->once())
            ->method('getExtensionAttributes')
            ->willReturn($this->extensionAttributes);

        $this->extensionAttributes->expects($this->once())
            ->method('setPetKindCustomer')
            ->with($this->petKindCustomer);

        $this->customerSearchResults->expects($this->once())
            ->method('setItems');

        $result = $this->plugin->afterGetList($this->customerRepository, $this->customerSearchResults);
        $this->assertEquals($this->customerSearchResults, $result);
    }
}
