<?php

namespace Bss\FAQs\Model\FAQs;

use Magento\Framework\Model\AbstractModel;

/**
 *
 */
class DataExample extends AbstractModel
{
    /**
     * FAQs Statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**
     * @return void
     */
    public function _construct()
    {
        $this->_init("Bss\FAQs\Model\FAQs\ResourceModel\DataExample");
    }

    /**
     * Prepare FAQs's statuses.
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Active'), self::STATUS_DISABLED => __('InActive')];
    }
}
