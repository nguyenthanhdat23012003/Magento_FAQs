<?php

namespace Bss\FAQs\Model\Category\ResourceModel;

use Magento\Catalog\Model\ImageUploader;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

/**
 * Class DataExample
 */
class DataExample extends AbstractDb
{
    /**
     * @var ImageUploader
     */
    protected ImageUploader $imageUploader;

    /**
     * @var
     */
    protected $_storeManager;

    /**
     * @param Context $context
     * @param ImageUploader $imageUploader
     * @param $connectionName
     */
    public function __construct(
        Context $context,
        ImageUploader $imageUploader,
        $connectionName = null
    ) {
        parent::__construct($context, $connectionName);
        $this->imageUploader = $imageUploader;
    }

    /**
     * @return void
     */
    public function _construct()
    {
        $this->_init("bss_faq_categories", "id");
    }

    /**
     * @param AbstractModel $object
     * @return $this|DataExample
     */
    protected function _afterSave(AbstractModel $object)
    {
        $icon = $object->getData('icon');
        $upLoad = $object->getData('upLoad');
        if ($icon != null && $upLoad) {
//            var_dump($this->imageUploader);die();
            $this->imageUploader->moveFileFromTmp($icon);
        }
        return $this;
    }
}
