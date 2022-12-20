<?php

namespace Bss\FAQs\Model\Category;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;
use Bss\FAQs\Api\Data\CategoryInterface;
/**
 *
 */
class DataExample extends AbstractModel implements CategoryInterface, IdentityInterface
{
    /**
     * Category Statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    const CACHE_TAG = 'bss_faqs_category';

    /**
     * @return void
     */
    public function _construct()
    {
        $this->_init("Bss\FAQs\Model\Category\ResourceModel\DataExample");
    }

    /**
     * Prepare category's statuses.
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Active'), self::STATUS_DISABLED => __('InActive')];
    }

    /**
     * @return array|mixed|null
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * @return array|mixed|null
     */
    public function getIcon()
    {
        return $this->getData(self::ICON);
    }

    /**
     * @return array|mixed|null
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @return array|mixed|null
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * Return identities
     * @return string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @param $title
     * @return DataExample|mixed
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * @param $status
     * @return DataExample|mixed
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * @param $icon
     * @return DataExample|mixed
     */
    public function setIcon($icon)
    {
        return $this->setData(self::ICON, $icon);
    }

    /**
     * @param $id
     * @return DataExample|mixed
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }


}
