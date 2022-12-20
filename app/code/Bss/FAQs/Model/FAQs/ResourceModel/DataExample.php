<?php
namespace Bss\FAQs\Model\FAQs\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class DataExample
 */
class DataExample extends AbstractDb
{

    /**
     * @return void
     */
    public function _construct()
    {
        $this->_init("bss_faqs", "id");
    }


}

?>
