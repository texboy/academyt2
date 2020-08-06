<?php
/*
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetCrud\Test\Unit\Controller\Adminhtml\Crud;

use Magento\Backend\Helper\Data;
use Magento\Backend\Model\Session;
use Magento\Framework\App\ActionFlag;
use Magento\Framework\App\Request\Http;
use Magento\Framework\App\ViewInterface;
use Magento\Framework\Message\Manager;
use Magento\Framework\ObjectManager\ObjectManager;
use PHPUnit\Framework\TestCase;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager as ObjectManagerHelper;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Page\Title;
use Magento\Framework\View\Page\Config;
use PHPUnit_Framework_MockObject_MockObject;
use Webjump\PetCrud\Controller\Adminhtml\Crud\Index;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class IndexTest extends TestCase
{
    /**
     * @var Index
     */
    private $action;

    /**
     * @var Context|PHPUnit_Framework_MockObject_MockObject
     */
    private $context;

    /**
     * @var Http|PHPUnit_Framework_MockObject_MockObject
     */
    private $request;

    /**
     * @var ResponseInterface|PHPUnit_Framework_MockObject_MockObject
     */
    private $response;

    /**
     * @var Manager|PHPUnit_Framework_MockObject_MockObject
     */
    private $messageManager;

    /**
     * @var ObjectManager|PHPUnit_Framework_MockObject_MockObject
     */
    private $objectManager;

    /**
     * @var Session|PHPUnit_Framework_MockObject_MockObject
     */
    private $session;

    /**
     * @var ActionFlag|PHPUnit_Framework_MockObject_MockObject
     */
    private $actionFlag;

    /**
     * @var Data|PHPUnit_Framework_MockObject_MockObject
     */
    private $helper;

    /**
     * @var  ViewInterface|PHPUnit_Framework_MockObject_MockObject
     */
    private $view;

    /**
     * @var PageFactory
     */
    private $resultPageFactoryMock;

    /**
     * @var Page|PHPUnit_Framework_MockObject_MockObject
     */
    private $resultPageMock;

    /**
     * @var Config|PHPUnit_Framework_MockObject_MockObject
     */
    private $pageConfigMock;

    /**
     * @var Title|PHPUnit_Framework_MockObject_MockObject
     */
    private $pageTitleMock;


    /**
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function setUp()
    {
        $objectManagerHelper = new ObjectManagerHelper($this);

        $this->objectManager = $this->createMock(\Magento\Framework\ObjectManagerInterface::class);

        $this->context = $this->getMockBuilder(Context::class)
            ->disableOriginalConstructor()
            ->setMethods([])
            ->getMock();

        $this->context = $this->createPartialMock(Context::class, [
            'getRequest',
            'getResponse',
            'getMessageManager',
            'getRedirect',
            'getObjectManager',
            'getSession',
            'getActionFlag',
            'getHelper',
            'getView'
        ]);

        $this->response = $this->createPartialMock(ResponseInterface::class, [
            'setRedirect',
            'sendResponse'
        ]);

        $this->request = $this->getMockBuilder(Http::class)
            ->disableOriginalConstructor()->getMock();

        $this->messageManager = $this->createPartialMock(Manager::class, [
            'addSuccess',
            'addErrorMessage'
        ]);

        $this->session = $this->createPartialMock(Session::class, [
            'setIsUrlNotice',
            'getCommentText'
        ]);

        $this->actionFlag = $this->createPartialMock(ActionFlag::class, ['get']);
        $this->helper = $this->createPartialMock(Data::class, ['getUrl']);
        $this->view = $this->createMock(ViewInterface::class);

        $this->context->expects($this->once())
            ->method('getMessageManager')
            ->will($this->returnValue($this->messageManager));
        $this->context->expects($this->once())
            ->method('getRequest')
            ->will($this->returnValue($this->request));
        $this->context->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($this->response));
        $this->context->expects($this->once())
            ->method('getObjectManager')
            ->will($this->returnValue($this->objectManager));
        $this->context->expects($this->once())
            ->method('getSession')
            ->will($this->returnValue($this->session));
        $this->context->expects($this->once())
            ->method('getActionFlag')
            ->will($this->returnValue($this->actionFlag));
        $this->context->expects($this->once())
            ->method('getHelper')
            ->will($this->returnValue($this->helper));
        $this->context
            ->expects($this->once())
            ->method('getView')
            ->will($this->returnValue($this->view));


        $this->resultPageFactoryMock = $this->createMock(PageFactory::class);
        $this->resultPageMock = $this->getMockBuilder(Page::class)
            ->disableOriginalConstructor()
            ->setMethods(['setActiveMenu','getConfig'])
            ->getMockForAbstractClass();
        $this->pageConfigMock = $this->getMockBuilder(Config::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->pageTitleMock = $this->getMockBuilder(Title::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->action = (new ObjectManagerHelper($this))->getObject(
            Index::class,
            [
                'context' => $this->context,
                'resultPageFactory' => $this->resultPageFactoryMock
            ]
        );
    }

    /**
     * @return void
     */
    public function testExecuteShouldCreatePage(): void
    {
        $this->resultPageFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($this->resultPageMock);

        $this->resultPageMock->expects($this->once())
            ->method('setActiveMenu');

        $this->resultPageMock->expects($this->once())
            ->method('setActiveMenu');

        $this->resultPageMock->expects($this->once())
            ->method('getConfig')
            ->willReturn($this->pageConfigMock);

        $this->pageConfigMock->expects($this->once())
            ->method('getTitle')
            ->willReturn($this->pageTitleMock);

        $this->pageTitleMock->expects($this->once())
            ->method('set')
            ->willReturn($this->pageTitleMock);

        $this->action->execute();
    }

    /**
     * @return void
     */
    public function testExecuteShouldAddMessageOnLocalizedExceptionAndRedirect(): void
    {
        $errorMessage = __('Error');

        $this->resultPageFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($this->resultPageMock);

        $this->resultPageMock->expects($this->once())
            ->method('setActiveMenu')
            ->willThrowException(new LocalizedException($errorMessage));

        $this->messageManager->expects($this->once())
            ->method('addErrorMessage')
            ->with($errorMessage);

        $this->action->execute();
    }

    /**
     * @return void
     */
    public function testExecuteShouldAddMessageOnException(): void
    {
        $errorMessage = 'Error';

        $this->resultPageFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($this->resultPageMock);

        $this->resultPageMock->expects($this->once())
            ->method('setActiveMenu')
            ->willThrowException(new \Exception($errorMessage));

        $this->messageManager->expects($this->once())
            ->method('addErrorMessage')
            ->with(__($errorMessage));

        $this->action->execute();
    }
}
