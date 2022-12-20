<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Bss\FAQs\Controller\Adminhtml\Faqs;

use Bss\FAQs\Model\FAQs\DataExampleFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Bss\FAQs\Model\FAQs\ResourceModel\DataExample;

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
    const ADMIN_RESOURCE = 'Bss_FAQs::save';

    /**
     * Core registry
     *
     * @var Registry
     */
    protected $_coreRegistry;

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var DataExampleFactory
     */
    protected $FAQsFactory;

    /**
     * @var DataExample
     */
    protected $faqResource;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param DataExampleFactory $FAQsFactory
     */
    public function __construct(
        Action\Context $context,
        PageFactory    $resultPageFactory,
        DataExampleFactory $FAQsFactory,
        DataExample $faqResource,
    ) {
        $this->faqResource = $faqResource;
        $this->FAQsFactory = $FAQsFactory;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
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

    /**
     * Edit CMS page
     *
     * @return Page|Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('id');
        $model = $this->FAQsFactory->create();

        // 2. Initial checking
        if ($id) {
            $this->faqResource->load($model,$id);
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
            ->prepend($model->getId() ? $model->getTitle() : __('New FAQs'));

        return $resultPage;
    }
}
