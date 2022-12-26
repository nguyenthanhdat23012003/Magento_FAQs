<?php

namespace Bss\FAQs\Block\Category;

use Bss\FAQs\Model\Category\ResourceModel\DataExample\Collection;
use Bss\FAQs\Model\Category\ResourceModel\DataExample\CollectionFactory;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\StoreManagerInterface;
use Bss\FAQs\Model\CategoryRepository;

/**
 * Class CategorySidebar
 */
class CategorySidebar extends Template
{
    /**
     * @var CategoryRepository
     */
    protected   $categoryRepository;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @param Context $context

     * @param StoreManagerInterface $storeManager
     * @param array $data
     */
    public function __construct(
        Context                                                          $context,
        CategoryRepository                                               $categoryRepository,
        StoreManagerInterface                                            $storeManager,
        array                                                            $data = []
    ) {
        $this->storeManager = $storeManager;
        $this->categoryRepository = $categoryRepository;
        parent::__construct($context);
    }

    /**
     * Get list of Category
     * @return Collection
     */
    public function getCategoryCollection()
    {
        return $this->categoryRepository->getCategoryCollection();
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
