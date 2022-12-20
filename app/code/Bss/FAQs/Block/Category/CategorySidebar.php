<?php

namespace Bss\FAQs\Block\Category;

use Bss\FAQs\Model\Category\ResourceModel\DataExample\Collection;
use Bss\FAQs\Model\Category\ResourceModel\DataExample\CollectionFactory;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class CategorySidebar
 */
class CategorySidebar extends Template
{

    /**
     * @var \Bss\FAQs\Model\FAQs\ResourceModel\DataExample\CollectionFactory
     */
    protected $_questionCollectionFactory;

    /**
     * @var CollectionFactory
     */
    protected $_categoryCollectionFactory;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @param Context $context
     * @param \Bss\FAQs\Model\FAQs\ResourceModel\DataExample\CollectionFactory $questionCollectionFactory
     * @param CollectionFactory $categoryCollectionFactory
     * @param StoreManagerInterface $storeManager
     * @param array $data
     */
    public function __construct(
        Context                                                          $context,
        \Bss\FAQs\Model\FAQs\ResourceModel\DataExample\CollectionFactory $questionCollectionFactory,
        CollectionFactory                                                $categoryCollectionFactory,
        StoreManagerInterface                                            $storeManager,
        array                                                            $data = []
    ) {
        $this->storeManager = $storeManager;
        $this->_questionCollectionFactory = $questionCollectionFactory;
        $this->_categoryCollectionFactory = $categoryCollectionFactory;
        parent::__construct($context);
    }

    /**
     * Get list of Category
     * @return Collection
     */
    public function getCategoryCollection()
    {
        $categoryCollection = $this->_categoryCollectionFactory->create()
            ->addFieldToFilter('status', 1);
        foreach ($categoryCollection as $cat) {
            $questionCollection = $this->_questionCollectionFactory->create()
                ->addFieldToFilter('category', $cat['id'])
                ->addFieldToFilter('status', 1);
            $cat['count'] = count($questionCollection);
        }
        return $categoryCollection;
    }

    /**
     * Get link of Category
     * @param $identifier
     * @return string
     * @throws NoSuchEntityException
     */
    public function getFaqCategoryFullPath($identifier)
    {
        return $this->storeManager->getStore()->getUrl('faqs/category/index', ['id' => $identifier]);
    }
}
