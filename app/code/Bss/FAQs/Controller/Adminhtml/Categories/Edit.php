<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Bss\FAQs\Controller\Adminhtml\Categories;

use Bss\FAQs\Model\Category\DataExampleFactory;
use Bss\FAQs\Model\Category\ResourceModel\DataExample;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;

/**
 * Edit CMS page action.
 */
class Edit extends Action implements HttpGetActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Bss_FAQs::Category_save';

    /**
     * @var PageFactory
     */
    protected PageFactory $resultPageFactory;

    /**
     * @var DataExampleFactory
     */
    protected DataExampleFactory $categoryFactory;

    /**
     * @var DataExample
     */
    protected DataExample $categoryResource;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param DataExampleFactory $categoryFactory
     * @param DataExample $categoryResource
     */
    public function __construct(
        Action\Context     $context,
        PageFactory        $resultPageFactory,
        DataExampleFactory $categoryFactory,
        DataExample $categoryResource,
    )
    {
        $this->categoryResource = $categoryResource;
        $this->categoryFactory = $categoryFactory;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Check admin permissions for this controller
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed($this::ADMIN_RESOURCE);
    }

    /**
     * Edit Category page
     *
     * @return Page|Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('id');
        $model = $this->categoryFactory->create();

        // 2. Initial checking
        if ($id) {
            $this->categoryResource->load($model,$id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This page no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        // 3. Build edit form
        /** @var Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getTitle() : __('New Categories'));

        return $resultPage;
    }

    /**
     * Init actions
     *
     * @return Page
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Bss_FAQs::faqs');
        return $resultPage;
    }
}
