<?php
declare(strict_types=1);

namespace Bss\FAQs\Block\Search;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class SearchForm
 */
class SearchForm extends Template
{

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     * @param array $data
     */
    public function __construct(
        Context               $context,
        StoreManagerInterface $storeManager,
        array                 $data = [],
    ) {
        $this->storeManager = $storeManager;
        parent::__construct($context, $data);
    }

    /**
     * Returns action url for search form
     *
     * @return string
     * @throws NoSuchEntityException
     */
    public function getFormAction()
    {
        return $this->storeManager->getStore()->getUrl('faqs/search/', [
            '_secure' => $this->storeManager->getStore()->isCurrentlySecure()]);
    }

    /**
     * Get Text search from url
     *
     * @return string
     */
    public function getTextSearch()
    {
        return ($this->getRequest()->getParam('s')) ? $this->getRequest()->getParam('s') : '';
    }
}
