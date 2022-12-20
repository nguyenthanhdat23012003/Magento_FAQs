<?php
namespace Bss\FAQs\Model\FAQs\ResourceModel\DataExample;

use Bss\FAQs\Model\FAQs\ResourceModel\DataExample;
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
        $this->_init(\Bss\FAQs\Model\FAQs\DataExample::class, DataExample::class);
    }
}

?>
