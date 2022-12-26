<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Bss\FAQs\Model;

use Bss\FAQs\Model\Category\ResourceModel\DataExample\Collection;
use Bss\FAQs\Model\Category\ResourceModel\DataExample\CollectionFactory;


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
     * CategoryRepository constructor.
     *
     * @param FAQs\ResourceModel\DataExample\CollectionFactory $questionCollectionFactory
     * @param CollectionFactory $categoryCollectionFactory
     */
    public function __construct(
        \Bss\FAQs\Model\FAQs\ResourceModel\DataExample\CollectionFactory $questionCollectionFactory,
        CollectionFactory                                                $categoryCollectionFactory,
    ) {
        $this->_questionCollectionFactory = $questionCollectionFactory;
        $this->_categoryCollectionFactory = $categoryCollectionFactory;
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
}
