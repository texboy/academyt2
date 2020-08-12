<?php
/*
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetCrud\Controller\Adminhtml\Crud;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Result\PageFactory;
use Webjump\PetCrud\Api\PetTypeSaveProcessorInterface;

/**
 * @codeCoverageIgnore
 */
class Save extends Action implements HttpPostActionInterface
{
    const URL_PATH_DEFAULT = 'pet/crud/index';

    /**
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Webjump_PetCrud::save';

    /**
     * @var PageFactory
     */
    private $resultPageFactory;

    /**
     * @var PetTypeSaveProcessorInterface
     */
    private $petTypeSaveProcessor;

    /**
     * Save constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param PetTypeSaveProcessorInterface $petTypeSaveProcessor
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        PetTypeSaveProcessorInterface $petTypeSaveProcessor
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->petTypeSaveProcessor = $petTypeSaveProcessor;
    }

    /**
     * @inheritDoc
     */
    public function execute(): ResultInterface
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        try {
            $this->petTypeSaveProcessor->process($this->getRequest()->getParams());
            $this->messageManager->addSuccessMessage('The pet type was saved!');
            $resultRedirect->setPath(self::URL_PATH_DEFAULT);
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $this->_redirect(self::URL_PATH_DEFAULT);
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        return $resultRedirect;
    }
}
