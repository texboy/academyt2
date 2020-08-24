<?php
/*
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetKindCustomer\Test\Unit\ViewModel;

use Magento\Customer\Api\Data\CustomerExtensionInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\Api\AttributeInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use Webjump\PetKindCustomer\Api\Data\PetKindCustomerInterface;
use Webjump\PetKindCustomer\ViewModel\CustomerData;

class CustomerDataTest extends TestCase
{
    /**
     * @var Session
     */
    private $customerSession;

    /**
     * @var CustomerInterface
     */
    private $customer;

    /**
     * @var AttributeInterface
     */
    private $customAttribute;

    /**
     * @var CustomerExtensionInterface
     */
    private $extensionAttributes;

    /**
     * @var PetKindCustomerInterface
     */
    private $petKindCustomer;

    /**
     * @var CustomerData
     */
    private $viewModel;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $objectManager = new ObjectManager($this);

        $this->customerSession = $this->createMock(Session::class);
        $this->customer = $this->createMock(CustomerInterface::class);
        $this->customAttribute = $this->createMock(AttributeInterface::class);
        $this->extensionAttributes = $this->getMockBuilder(CustomerExtensionInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['getPetKindCustomer'])
            ->getMockForAbstractClass();
        $this->petKindCustomer = $this->createMock(PetKindCustomerInterface::class);

        $this->viewModel = $objectManager->getObject(CustomerData::class, [
            'customerSession' => $this->customerSession
        ]);
    }

    /**
     * @return void
     */
    public function testGetCustomerDataShouldReturnCustomerInterface(): void
    {
        $this->customerSession->expects($this->once())
            ->method('getCustomerData')
            ->willReturn($this->customer);

        $result = $this->viewModel->getCustomerData();
        $this->assertEquals($this->customer, $result);
    }

    /**
     * @return void
     */
    public function testGetCustomerDataShouldReturnNullOnException(): void
    {
        $this->customerSession->expects($this->once())
            ->method('getCustomerData')
            ->willThrowException(new NoSuchEntityException(__('error')));

        $result = $this->viewModel->getCustomerData();
        $this->assertNull($result);
    }

    /**
     * @return void
     */
    public function testGetPetKindSelectedIdShouldReturnInt(): void
    {
        $petKindId = 1;
        $this->customerSession->expects($this->once())
            ->method('getCustomerData')
            ->willReturn($this->customer);

        $this->customer->expects($this->once())
            ->method('getExtensionAttributes')
            ->willReturn($this->extensionAttributes);

        $this->extensionAttributes->expects($this->once())
            ->method('getPetKindCustomer')
            ->willReturn($this->petKindCustomer);

        $this->petKindCustomer->expects($this->once())
            ->method('getPetKindId')
            ->willReturn($petKindId);

        $result = $this->viewModel->getPetKindSelectedId();
        $this->assertEquals($petKindId, $result);
    }

    /**
     * @return void
     */
    public function testGetPetKindCustomerShouldReturnOnException(): void
    {
        $this->customerSession->expects($this->once())
            ->method('getCustomerData')
            ->willThrowException(new NoSuchEntityException(__('error')));

        $result = $this->viewModel->getPetKindSelectedId();
        $this->assertNull($result);
    }

    /**
     * @return void
     */
    public function testGetPetNameShouldReturnString(): void
    {
        $petName = 'test';

        $this->customerSession->expects($this->once())
            ->method('getCustomerData')
            ->willReturn($this->customer);

        $this->customer->expects($this->once())
            ->method('getCustomAttribute')
            ->willReturn($this->customAttribute);

        $this->customAttribute->expects($this->once())
            ->method('getValue')
            ->willReturn($petName);

        $result = $this->viewModel->getPetName();
        $this->assertEquals($petName, $result);
    }

    /**
     * @return void
     */
    public function testGetPetNameShouldReturnEmptyStringOnException(): void
    {
        $this->customerSession->expects($this->once())
            ->method('getCustomerData')
            ->willThrowException(new NoSuchEntityException(__('error')));

        $result = $this->viewModel->getPetName();
        $this->assertEmpty($result);
    }
}
