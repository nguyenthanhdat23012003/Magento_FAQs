<?php

namespace Bss\FAQs\Block\Category;

use Bss\FAQs\Model\Category\ResourceModel\DataExample\CollectionFactory as FaqCatCollectionFactory;
use Bss\FAQs\Model\FAQs\ResourceModel\DataExample\Collection;
use Bss\FAQs\Model\FAQs\ResourceModel\DataExample\CollectionFactory as FaqsCollectionFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Category
 */
class Category extends Template
{
    /**
     * @var FaqCatCollectionFactory|null
     */
    protected $_FaqCatCollectionFactory = null;
    /**
     * @var FaqsCollectionFactory|null
     */
    protected $_FaqsCollectionFactory = null;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @param Context $context
     * @param FaqsCollectionFactory $FaqsCollectionFactory
     * @param FaqCatCollectionFactory $FaqCatCollectionFactory
     * @param StoreManagerInterface $storeManager
     * @param array $data
     */
    public function __construct(
        Context                 $context,
        FaqsCollectionFactory   $FaqsCollectionFactory,
        FaqCatCollectionFactory $FaqCatCollectionFactory,
        StoreManagerInterface   $storeManager,
        array                   $data = []
    ) {
        $this->storeManager = $storeManager;
        $this->_FaqCatCollectionFactory = $FaqCatCollectionFactory;
        $this->_FaqsCollectionFactory = $FaqsCollectionFactory;
        parent::__construct($context, $data);
    }

    /**
     * Get Title of FAQ Category
     * @return string
     */
    public function getFaqCategoryTitle()
    {
        $id = $this->getRequest()->getParam('id');
        $categoryCollection = $this->_FaqCatCollectionFactory->create()
            ->addFieldToFilter('id', $id);
        $title = "";
        foreach ($categoryCollection as $faqcat) {
            $title = $faqcat->getTitle();
        }
        return $title;
    }

    /**
     * Get list FAQs
     * @return Collection|null
     */
    public function getFaqsList()
    {
        $id = $this->getRequest()->getParam('id');
        $faqCollection = $this->_FaqsCollectionFactory->create()
            ->addFieldToFilter('status', 1)
            ->addFieldToFilter('category', $id);
        if (count($faqCollection) == 0) {
            return null;
        }
        return $faqCollection;
    }

    /**
     * Get Icon of FAQ Category
     * @return string
     * @throws NoSuchEntityException
     */
    public function getFaqCategoryIcon()
    {
        $id = $this->getRequest()->getParam('id');
        $category = $this->_FaqCatCollectionFactory->create()
            ->addFieldToFilter('id', $id);
        $icon = "";
        foreach ($category as $faqcat) {
            $icon = $faqcat->getIcon();
        }
        return $this->storeManager->getStore()
                ->getBaseUrl(
                    UrlInterface::URL_TYPE_MEDIA
                ) . 'faqs/imgcategories/' . $icon;
    }
}
