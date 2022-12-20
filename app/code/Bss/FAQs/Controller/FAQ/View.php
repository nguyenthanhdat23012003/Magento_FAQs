<?php

namespace Bss\FAQs\Controller\FAQ;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class View
 */
class View implements HttpGetActionInterface, HttpPostActionInterface
{
    /**
     * @var PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        PageFactory $resultPageFactory
    ) {
        $this->_resultPageFactory = $resultPageFactory;
    }

    /**
     * View action
     *
     * @return Page
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        return $this->_resultPageFactory->create();
    }
}
