<?php

namespace Bss\FAQs\Controller\Adminhtml\Faqs;

use Bss\FAQs\Model\FAQs\DataExampleFactory;
use Bss\FAQs\Model\FAQs\ResourceModel\DataExample;
use Bss\FAQs\Model\FAQs\ResourceModel\DataExample\CollectionFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;

/**
 *
 */
class MassEnabled extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Bss_FAQs::edit';

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
    protected $faqFactory;

    /**
     * @var DataExample
     */
    protected $faqResource;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param DataExampleFactory $faqFactory
     * @param DataExample $faqResource
     */
    public function __construct(
        Context            $context,
        Filter             $filter,
        CollectionFactory  $collectionFactory,
        DataExampleFactory $faqFactory,
        DataExample        $faqResource,
    )
    {
        $this->faqResource = $faqResource;
        $this->faqFactory = $faqFactory;
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
        // Get collection
        $collection = $this->filter->getCollection($this->collectionFactory->create());

        // Update status to Disable
        foreach ($collection as $faq) {
            $item = $this->faqFactory->create();
            $this->faqResource->load($item, $faq->getId());
            $item->setStatus(true);
            $this->faqResource->save($item);
        }

        // Display success message
        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been enabled.', $collection->getSize()));

        // Redirect to List page
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
