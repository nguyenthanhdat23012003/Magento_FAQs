<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Bss\FAQs\Model;

use Bss\FAQs\Model\Category\ResourceModel\DataExample\CollectionFactory as ViewCollectionFactory;
use Bss\FAQs\Model\FAQs\ResourceModel\DataExample\CollectionFactory as FaqsCollectionFactory;

class SearchRepository
{
    /**
     * @var ViewCollectionFactory
     */
    protected $_viewCollectionFactory;

    /**
     * @var FaqsCollectionFactory
     */
    protected $_faqsCollectionFactory;

    public function __construct(
        ViewCollectionFactory $viewCollectionFactory,
        FaqsCollectionFactory $faqsCollectionFactory,
    ) {
        $this->_viewCollectionFactory = $viewCollectionFactory;
        $this->_faqsCollectionFactory = $faqsCollectionFactory;
    }

    public function getFaqCategoriesList()
    {
        $search = $this->getTextSearch();
        return $this->_viewCollectionFactory->create()
            ->addFieldToFilter('status', 1)
            ->addFieldToFilter('title', ['like' => '%' . $search . '%']);
    }

    public function getFaqsList()
    {
        $search = $this->getTextSearch();
        $faqCollection = $this->_faqsCollectionFactory->create()
            ->addFieldToFilter('status', 1)
            ->addFieldToFilter(array('title','answer'), [['like' => '%' . $search . '%'],['like' => '%' . $search . '%']]);
        if (count($faqCollection) == 0) {
            return null;
        }
        return $faqCollection;
    }

}
