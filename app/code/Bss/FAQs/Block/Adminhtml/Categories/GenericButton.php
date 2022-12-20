<?php
declare(strict_types=1);

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Bss\FAQs\Block\Adminhtml\Categories;

use Bss\FAQs\Model\Category\DataExampleFactory;
use Bss\FAQs\Model\Category\ResourceModel\DataExample;
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
    protected $CategoryFactory;

    /**
     * @var DataExample
     */
    protected $categoryResource;

    /**
     * @param Context $context
     * @param DataExampleFactory $CategoryFactory
     * @param DataExample $categoryResource
     */
    public function __construct(
        Context            $context,
        DataExampleFactory $CategoryFactory,
        DataExample $categoryResource,
    ) {
        $this->categoryResource = $categoryResource;
        $this->context = $context;
        $this->CategoryFactory = $CategoryFactory;
    }

    /**
     * Return CMS page ID
     *
     * @return int|null
     */
    public function getCategoryID()
    {
        $id = $this->context->getRequest()->getParam('id');
        $category = $this->CategoryFactory->create();
        $this->categoryResource->load($category, $id);
        if ($category->getId()) {
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
