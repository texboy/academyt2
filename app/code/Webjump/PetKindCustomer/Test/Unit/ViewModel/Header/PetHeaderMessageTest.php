<?php
/*
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetKindCustomer\Test\Unit\ViewModel\Header;

use Magento\Customer\Api\Data\CustomerExtensionInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\Api\AttributeInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\StoreManagerInterface;
use PHPUnit\Framework\TestCase;
use Webjump\PetKind\Api\Data\PetKindInterface;
use Webjump\PetKind\Api\PetKindRepositoryInterface;
use Webjump\PetKindCustomer\Api\Data\PetKindCustomerInterface;
use Webjump\PetKindCustomer\ViewModel\Header\PetHeaderMessage;

class PetHeaderMessageTest extends TestCase
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
     * @var PetKindRepositoryInterface
     */
    private $petKindRepository;

    /**
     * @var PetKindInterface
     */
    private $petKind;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var StoreInterface
     */
    private $store;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var PetHeaderMessage
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
        $this->petKindRepository = $this->createMock(PetKindRepositoryInterface::class);
        $this->petKind = $this->createMock(PetKindInterface::class);
        $this->storeManager = $this->createMock(StoreManagerInterface::class);
        $this->store = $this->createMock(StoreInterface::class);
        $this->scopeConfig = $this->createMock(ScopeConfigInterface::class);

        $this->viewModel = $objectManager->getObject(PetHeaderMessage::class, [
            'customerSession' => $this->customerSession,
            'petKindRepository' => $this->petKindRepository,
            'storeManager' => $this->storeManager,
            'scopeConfig' => $this->scopeConfig
        ]);
    }

    /**
     * @return void
     */
    public function testGetPetNameAndKindShouldReturnCouldNotFindPetPhrase(): void
    {
        $expectedResult = __("Could not find a pet!");
        $isLoggedIn = false;

        $this->customerSession->expects($this->once())
            ->method('isLoggedIn')
            ->willReturn($isLoggedIn);

        $result = $this->viewModel->getPetNameAndKind();
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @return void
     */
    public function testGetPetNameAndKindShouldReturnCouldNotFindPetPhraseOnStoreNotExist(): void
    {
        $isLoggedIn = true;
        $expectedResult = __("Could not find a pet!");

        $this->customerSession->expects($this->once())
            ->method('isLoggedIn')
            ->willReturn($isLoggedIn);

        $this->storeManager->expects($this->once())
            ->method('getStore')
            ->willThrowException(new NoSuchEntityException(__('error')));

        $result = $this->viewModel->getPetNameAndKind();
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @return void
     */
    public function testGetPetNameAndKindShouldReturnPetPhrase(): void
    {
        $isLoggedIn = true;
        $storeId = 1;
        $petKindId = 1;
        $canShowpet = true;
        $petKind = "dog";
        $petName = "rex";
        $expectedResult = __("You got a %1 named %2", $petKind, $petName);

        $this->customerSession->expects($this->once())
            ->method('isLoggedIn')
            ->willReturn($isLoggedIn);

        $this->storeManager->expects($this->once())
            ->method('getStore')
            ->willReturn($this->store);

        $this->store->expects($this->once())
            ->method('getId')
            ->willReturn($storeId);

        $this->scopeConfig->expects($this->once())
            ->method('getValue')
            ->willReturn($canShowpet);

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

        $this->petKindRepository->expects($this->once())
            ->method('getById')
            ->willReturn($this->petKind);

        $this->petKind->expects($this->once())
            ->method('getName')
            ->willReturn($petKind);

        $this->customer->expects($this->once())
            ->method('getCustomAttribute')
            ->willReturn($this->customAttribute);

        $this->customAttribute->expects($this->once())
            ->method('getValue')
            ->willReturn($petName);

        $result = $this->viewModel->getPetNameAndKind();
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @return void
     */
    public function testGetPetNameAndKindShouldReturnEmptyPhraseOnException(): void
    {
        $isLoggedIn = true;
        $storeId = 1;
        $petKindId = 1;
        $canShowpet = true;
        $expectedResult = __("");

        $this->customerSession->expects($this->once())
            ->method('isLoggedIn')
            ->willReturn($isLoggedIn);

        $this->storeManager->expects($this->once())
            ->method('getStore')
            ->willReturn($this->store);

        $this->store->expects($this->once())
            ->method('getId')
            ->willReturn($storeId);

        $this->scopeConfig->expects($this->once())
            ->method('getValue')
            ->willReturn($canShowpet);

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

        $this->petKindRepository->expects($this->once())
            ->method('getById')
            ->willThrowException(new NoSuchEntityException(__('error')));

        $result = $this->viewModel->getPetNameAndKind();
        $this->assertEquals($expectedResult, $result);
    }
}
