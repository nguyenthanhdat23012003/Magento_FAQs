<?php

namespace Bss\FAQs\Controller\Adminhtml\Categories;

use Bss\FAQs\Model\Category\DataExampleFactory;
use Bss\FAQs\Model\Category\ResourceModel\DataExample\CollectionFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;
use Bss\FAQs\Model\Category\ResourceModel\DataExample;

/**
 *
 */
class MassDisable extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Bss_FAQs::Category_edit';
    /**
     * @var Filter
     */
    protected Filter $filter;
    /**
     * @var CollectionFactory
     */
    protected CollectionFactory $collectionFactory;

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
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param DataExampleFactory $categoryFactory
     * @param DataExample $categoryResource
     */
    public function __construct(
        Context            $context,
        Filter             $filter,
        CollectionFactory  $collectionFactory,
        DataExampleFactory $categoryFactory,
        DataExample $categoryResource,
    )
    {
        $this->categoryResource = $categoryResource;
        $this->categoryFactory = $categoryFactory;
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
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
     * @return ResponseInterface|ResultInterface
     * @throws LocalizedException
     */
    public function execute()
    {
        // Get collection
        $collection = $this->filter->getCollection($this->collectionFactory->create());

        // Update status to Disable
        foreach ($collection as $category) {
            $item = $this->categoryFactory->create();
            $this->categoryResource->load($item,$category->getId());
            $item->setStatus(false);
            $this->categoryResource->save($item);
        }

        // Display success message
        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been disabled.', $collection->getSize()));

        // Redirect to List page
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
