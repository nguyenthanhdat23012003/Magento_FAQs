<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Bss\FAQs\Model\FAQs\DataProvide\Source;

use Bss\FAQs\Model\Category\ResourceModel\DataExample\CollectionFactory;
use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Category
 */
class Category implements OptionSourceInterface
{

    /**
     * @var \Bss\FAQs\Model\Category\ResourceModel\DataExample\Collection
     */
    protected $collection;

    /**
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collection = $collectionFactory->create();
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $items = $this->collection->getItems();
        $options[] = ['label' => 'Unsigned', 'value' => ''];
        foreach ($items as $item) {
            $data = $item->getData();
            $idCategory = $data['id'];
            $titleCategory = $data['title'];
            $array[0] = ['label' => $titleCategory, 'value' => $idCategory];
            $options = array_merge($options, $array);
        }
        return $options;

    }
}
