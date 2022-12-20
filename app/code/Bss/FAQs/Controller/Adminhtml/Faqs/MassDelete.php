<?php

namespace Bss\FAQs\Controller\Adminhtml\Faqs;

use Bss\FAQs\Model\FAQs\DataExampleFactory;
use Bss\FAQs\Model\FAQs\ResourceModel\DataExample\CollectionFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;
use Bss\FAQs\Model\FAQs\ResourceModel\DataExample;

/**
 * Class MassDelete
 */
class MassDelete extends Action
{

    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Bss_FAQs::delete';

    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

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
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param DataExampleFactory $faqsFactory
     */
    public function __construct(
        Context            $context,
        Filter             $filter,
        CollectionFactory  $collectionFactory,
        DataExampleFactory $faqsFactory,
        DataExample $faqResource,
    )
    {
        $this->faqResource = $faqResource;
        $this->faqsFactory = $faqsFactory;
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|ResultInterface
     * @throws LocalizedException
     */
    public function execute()
    {
        // Get selected collection
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();

        // Delete collection
        foreach ($collection as $faqs) {
            $deleteItem = $this->faqsFactory->create();
            $this->faqResource->load($deleteItem,$faqs->getId());
            $this->faqResource->delete($deleteItem);
        }

        // Display success message
        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $collectionSize));

        // Redirect to List page
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
