<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Bss\FAQs\Model;


use Bss\FAQs\Model\Category\ResourceModel\DataExample\CollectionFactory as ViewCollectionFactory;
use Bss\FAQs\Model\FAQs\ResourceModel\DataExample\CollectionFactory as FaqsCollectionFactory;

class FaqsRepository
{
    /**
     * @var ViewCollectionFactory|null
     */
    protected $_viewCollectionFactory = null;

    /**
     * @var FaqsCollectionFactory|null
     */
    protected $_FaqsCollectionFactory = null;

    public function __construct(
        ViewCollectionFactory $viewCollectionFactory,
        FaqsCollectionFactory $FaqsCollectionFactory,
    ) {
        $this->_viewCollectionFactory = $viewCollectionFactory;
        $this->_FaqsCollectionFactory = $FaqsCollectionFactory;
    }

    public function getFaqCategoriesList()
    {
        $viewCollection = $this->_viewCollectionFactory->create()
            ->addFieldToFilter('status', 1);
        return $viewCollection;
    }

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
