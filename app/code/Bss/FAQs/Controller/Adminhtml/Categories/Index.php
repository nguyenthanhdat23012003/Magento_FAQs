<?php

namespace Bss\FAQs\Controller\Adminhtml\Categories;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 */
class Index extends Action
{
    /**
     * @var PageFactory
     */
    private $pageFactory;

    /**
     * Constructor
     *
     * @param Context $context
     * @param PageFactory $rawFactory
     */
    public function __construct(Context $context, PageFactory $rawFactory)
    {
        $this->pageFactory = $rawFactory;
        parent::__construct($context);
    }

    /**
     * @return Page
     */
    public function execute(): Page
    {
        $resultPage = $this->pageFactory->create();
        $resultPage->setActiveMenu('Bss_FAQs::faqs');
        $resultPage->getConfig()->getTitle()->prepend(__('FAQ categories'));
        return $resultPage;
    }
}
