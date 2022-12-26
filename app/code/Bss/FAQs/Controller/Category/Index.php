<?php
declare(strict_types=1);

namespace Bss\FAQs\Controller\Category;

use Bss\FAQs\Model\Category\DataExampleFactory;
use Exception;
use Bss\FAQs\Model\Category\ResourceModel\DataExample;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Message\ManagerInterface;

/**
 * Class Index
 */
class Index implements HttpGetActionInterface, HttpPostActionInterface
{

    /**
     * @var PageFactory
     */
    protected $_resultPageFactory;

     /**
      * @var ManagerInterface
      */
    protected $messageManager;
    /**
     * @var DataExampleFactory
     */
    protected $categoryFAQ;

    /**
     * @var DataExample
     */
    protected $categoryResource;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @param RequestInterface $request
     * @param PageFactory $resultPageFactory
     * @param DataExampleFactory $categoryFAQ
     * @param DataExample $categoryResource
     */
    public function __construct(
        ManagerInterface $messageManager,
        RequestInterface $request,
        PageFactory        $resultPageFactory,
        DataExampleFactory $categoryFAQ,
        DataExample $categoryResource,
    ) {
        $this->messageManager = $messageManager;
        $this->request = $request;
        $this->categoryResource = $categoryResource;
        $this->categoryFAQ = $categoryFAQ;
        $this->_resultPageFactory = $resultPageFactory;
    }

    /**
     * View action
     *
     * @return \Magento\Framework\View\Result\Page
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $id = $this->request->getParam('id');
        $category = $this->categoryFAQ->create();
        try {
            $this->categoryResource->load($category, $id);
        } catch (Exception $e) {
            // Display error message
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('FAQs'));
        $resultPage->getConfig()->getTitle()->prepend(__($category['title']));
        return $resultPage;
    }
}
