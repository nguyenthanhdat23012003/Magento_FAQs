<?php
declare(strict_types=1);

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Bss\FAQs\Block\Adminhtml\Faqs;

use Bss\FAQs\Model\FAQs\DataExampleFactory;
use Bss\FAQs\Model\FAQs\ResourceModel\DataExample;
use Magento\Backend\Block\Widget\Context;

/**
 * Class GenericButton
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var DataExampleFactory
     */
    protected $FaqsFactory;

    /**
     * @var DataExample
     */
    protected $faqResource;

    /**
     * @param Context $context
     * @param DataExampleFactory $FaqsFactory
     * @param DataExample $faqResource
     */
    public function __construct(
        Context            $context,
        DataExampleFactory $FaqsFactory,
        DataExample        $faqResource,
    ) {
        $this->faqResource = $faqResource;
        $this->context = $context;
        $this->FaqsFactory = $FaqsFactory;
    }

    /**
     * Return CMS page ID
     *
     * @return int|null
     */
    public function getCategoryID()
    {
        $id = $this->context->getRequest()->getParam('id');
        $faqs = $this->FaqsFactory->create();
        $this->faqResource->load($faqs, $id);
        if ($faqs->getId()) {
            return $id;
        }
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param string $route
     * @param array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
