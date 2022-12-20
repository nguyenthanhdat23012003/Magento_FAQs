<?php

namespace Bss\FAQs\Controller\Adminhtml\Categories;

use Bss\FAQs\Model\Category\DataExampleFactory;
use Bss\FAQs\Model\Category\ResourceModel\DataExample;
use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;

/**
 *
 */
class Delete extends Action
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Bss_FAQs::Category_delete';

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
     * @param DataExampleFactory $categoryFactory
     * @param DataExample $categoryResource
     */
    public function __construct(
        Context            $context,
        DataExampleFactory $categoryFactory,
        DataExample        $categoryResource,
    )
    {
        $this->categoryResource = $categoryResource;
        $this->categoryFactory = $categoryFactory;
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
     * @return ResponseInterface|Redirect|ResultInterface
     */
    public function execute()
    {
        // Get ID of record by param
        $id = $this->getRequest()->getParam('id');

        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                // Init model and delete
                $model = $this->categoryFactory->create();
                $this->categoryResource->load($model, $id);
                $this->categoryResource->delete($model);

                // Display success message
                $this->messageManager->addSuccessMessage(__('The image has been deleted.'));

                // Redirect to list page
                return $resultRedirect->setPath('*/*/');
            } catch (Exception $e) {
                // Display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // Go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }

        // Display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a image to delete.'));

        // Redirect to list page
        return $resultRedirect->setPath('*/*/');
    }
}
