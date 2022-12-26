<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Bss\FAQs\Model;

use Bss\FAQs\Model\Category\ResourceModel\DataExample\Collection;
use Bss\FAQs\Model\Category\ResourceModel\DataExample\CollectionFactory;
use Bss\FAQs\Model\FAQs\ResourceModel\DataExample\CollectionFactory as FaqsCollectionFactory;
use Magento\Framework\View\Element\Template;

/**
 * Centralize common data access functionality for the Adobe Stock category.
 *
 *  Uses commands as proxy for those operations.
 */
class CategoryRepository
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
     * @var FaqsCollectionFactory|null
     */
    protected $_FaqsCollectionFactory = null;

    /**
     * CategoryRepository constructor.
     * @param FaqsCollectionFactory $FaqsCollectionFactory
     * @param FAQs\ResourceModel\DataExample\CollectionFactory $questionCollectionFactory
     * @param CollectionFactory $categoryCollectionFactory
     */
    public function __construct(
        \Bss\FAQs\Model\FAQs\ResourceModel\DataExample\CollectionFactory $questionCollectionFactory,
        CollectionFactory                                                $categoryCollectionFactory,
        FaqsCollectionFactory                                            $FaqsCollectionFactory
    ) {
        $this->_questionCollectionFactory = $questionCollectionFactory;
        $this->_categoryCollectionFactory = $categoryCollectionFactory;
        $this->_FaqsCollectionFactory = $FaqsCollectionFactory;
    }

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
}
