<?php
namespace Bss\FAQs\Model\Category\ResourceModel\DataExample;

use Bss\FAQs\Model\Category\ResourceModel\DataExample;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 *  Class Collection
 */
class Collection extends AbstractCollection
{
    /**
     * @return void
     */
    public function _construct()
    {
        $this->_init(\Bss\FAQs\Model\Category\DataExample::class, DataExample::class);
    }
}

?>
