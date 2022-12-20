<?php

namespace Bss\FAQs\Controller\Adminhtml\Faqs;


use Bss\FAQs\Model\FAQs\DataExampleFactory;
use Bss\FAQs\Model\FAQs\ResourceModel\DataExample;
use Magento\Backend\App\Action\Context;


/**
 * Class Delete
 */
class Delete extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Bss_FAQs::delete';

    /**
     * @var DataExampleFactory
     */
    protected $faqsFactory;

    /**
     * @var DataExample
     */
    protected $faqResource;

    /**
     * @param Context $context
     * @param DataExampleFactory $faqsFactory
     * @param DataExample $faqResource
     */
    public function __construct(
        Context            $context,
        DataExampleFactory $faqsFactory,
        DataExample $faqResource,
    )
    {
        $this->faqResource = $faqResource;
        $this->faqsFactory = $faqsFactory;
        parent::__construct($context);
    }
    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        // Get ID of record by param
        $id = $this->getRequest()->getParam('id');

        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                // Init model and delete
                $model = $this->faqsFactory->create();
                $this->faqResource->load($model, $id);
                $this->faqResource->delete($model);

                // Display success message
                $this->messageManager->addSuccessMessage(__('The image has been deleted.'));

                // Redirect to list page
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
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
