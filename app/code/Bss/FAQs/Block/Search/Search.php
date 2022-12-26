<?php
declare(strict_types=1);

namespace Bss\FAQs\Block\Search;

use Bss\FAQs\Model\Category\ResourceModel\DataExample\Collection;
use Bss\FAQs\Model\Category\ResourceModel\DataExample\CollectionFactory as ViewCollectionFactory;
use Bss\FAQs\Model\CategoryRepository;
use Bss\FAQs\Model\FAQs\ResourceModel\DataExample\CollectionFactory as FaqsCollectionFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\StoreManagerInterface;
use Bss\FAQs\Model\SearchRepository;
/**
 * Class SearchForm
 */
class Search extends Template
{
    /**
     * @var SearchRepository
     */
    protected   $searchRepository;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @param Context $context
     * @param ViewCollectionFactory $viewCollectionFactory
     * @param FaqsCollectionFactory $faqsCollectionFactory
     * @param StoreManagerInterface $storeManager
     * @param array $data
     */
    public function __construct(
        Context               $context,
        SearchRepository      $searchRepository,
        StoreManagerInterface $storeManager,
        array                 $data = [],
    ) {
        $this->storeManager = $storeManager;
        $this->searchRepository = $searchRepository;
        parent::__construct($context, $data);
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
     * Get Full Path of FAQ Category
     *
     * @param $identifier
     * @return string
     * @throws NoSuchEntityException
     */
    public function getFaqCategoryFullPath($identifier)
    {
        return $this->storeManager->getStore()->getUrl('faqs/category/index', ['id' => $identifier]);
    }

    /**
     * @return Collection
     */
    public function getFaqCategoriesList()
    {
        return $this->searchRepository->getFaqCategoriesList();
    }

    /**
     * Get Text search from url
     *
     * @return string
     */
    public function getTextSearch()
    {
        return ($this->getRequest()->getParam('s')) ? $this->getRequest()->getParam('s') : '';
    }

    /**
     * Get list result Faq after search
     *
     * @return \Bss\FAQs\Model\FAQs\ResourceModel\DataExample\Collection|null
     */
    public function getFaqsList()
    {
        return $this->searchRepository->getFaqsList();
    }
}
