<?php
declare(strict_types=1);

namespace Bss\FAQs\Block\Faq;

use Bss\FAQs\Model\Category\ResourceModel\DataExample\Collection;
use Bss\FAQs\Model\Category\ResourceModel\DataExample\CollectionFactory as ViewCollectionFactory;
use Bss\FAQs\Model\FAQs\ResourceModel\DataExample\CollectionFactory as FaqsCollectionFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Faq
 */
class Faq extends Template
{
    /**
     * @var ViewCollectionFactory|null
     */
    protected $_viewCollectionFactory = null;
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
     * @param ViewCollectionFactory $viewCollectionFactory
     * @param FaqsCollectionFactory $FaqsCollectionFactory
     * @param StoreManagerInterface $storeManager
     * @param array $data
     */
    public function __construct(
        Context               $context,
        ViewCollectionFactory $viewCollectionFactory,
        FaqsCollectionFactory $FaqsCollectionFactory,
        StoreManagerInterface $storeManager,
        array                 $data = []
    ) {
        $this->storeManager = $storeManager;
        $this->_viewCollectionFactory = $viewCollectionFactory;
        $this->_FaqsCollectionFactory = $FaqsCollectionFactory;
        parent::__construct($context, $data);
    }

    /**
     * Get list of Category
     * @return Collection
     */
    public function getFaqCategoriesList()
    {
        $viewCollection = $this->_viewCollectionFactory->create()
            ->addFieldToFilter('status', 1);
        return $viewCollection;
    }

    /**
     * Get Icons of Category
     * @param $icon
     * @return string
     * @throws NoSuchEntityException
     */
    public function getFileBaseUrl($icon)
    {
        return $this->storeManager->getStore()
                ->getBaseUrl(
                    UrlInterface::URL_TYPE_MEDIA
                ) . 'faqs/imgcategories/' . $icon;
    }

    /**
     * Get link render Category
     * @param $identifier
     * @return string
     * @throws NoSuchEntityException
     */
    public function getFaqCategoryFullPath($identifier)
    {
        return $this->storeManager->getStore()->getUrl('faqs/category/index', ['id' => $identifier]);
    }

    /**
     * Get Frequently Asked Question
     * @return \Bss\FAQs\Model\FAQs\ResourceModel\DataExample\Collection|null
     */
    public function getFrequentlyAskedQuestion()
    {
        $faqCollection = $this->_FaqsCollectionFactory->create()
            ->addFieldToFilter('status', 1);
        if (count($faqCollection) == 0) {
            return null;
        }
        return $faqCollection;
    }
}
