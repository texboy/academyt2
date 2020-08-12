<?php
/*
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetCrud\Controller\Adminhtml\Crud;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

/**
 * @codeCoverageIgnore
 */
class Create extends Action
{
    const URL_PATH_DEFAULT = 'pet/crud/index';

    /**
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Webjump_PetCrud::create';

    /**
     * @var PageFactory
     */
    private $resultPageFactory;

    /**
     * Create constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * @return Page
     */
    public function execute(): Page
    {
        $resultPage = $this->resultPageFactory->create();
        try {
            $resultPage->setActiveMenu('Webjump_PetCrud::menu');
            $resultPage->getConfig()->getTitle()->set(__("Create"));
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $this->_redirect(self::URL_PATH_DEFAULT);
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        return $resultPage;
    }
}
