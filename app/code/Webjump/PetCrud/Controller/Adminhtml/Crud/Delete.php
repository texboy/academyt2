<?php
/*
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetCrud\Controller\Adminhtml\Crud;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Result\PageFactory;
use Webjump\PetType\Api\PetTypeRepositoryInterface;

/**
 * @codeCoverageIgnore
 */
class Delete extends Action implements HttpGetActionInterface
{
    const URL_PATH_DEFAULT = 'pet/crud/index';

    /**
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Webjump_PetCrud::delete';

    /**
     * @var PageFactory
     */
    private $resultPageFactory;

    /**
     * @var PetTypeRepositoryInterface
     */
    private $petTypeRepository;

    /**
     * Save constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param PetTypeRepositoryInterface $petTypeRepository
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        PetTypeRepositoryInterface $petTypeRepository
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->petTypeRepository = $petTypeRepository;
    }

    /**
     * @inheritDoc
     */
    public function execute(): ResultInterface
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        try {
            $this->petTypeRepository->deleteById((int)$this->getRequest()->getParam('entity_id'));
            $this->messageManager->addSuccessMessage('The pet type was deleted!');
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
