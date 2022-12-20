<?php
declare(strict_types=1);

/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Bss\FAQs\Controller\Adminhtml\Faqs;

use Magento\Framework\Message\ManagerInterface;

/**
 * Controller helper for user input.
 */
class PostDataProcessor
{
    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * @param ManagerInterface $messageManager
     */
    public function __construct(ManagerInterface $messageManager)
    {
        $this->messageManager = $messageManager;
    }

    /**
     * Check if required fields is not empty
     *
     * @param array $data
     * @return bool
     */
    public function validateRequireEntry(array $data)
    {
        $requiredFields = ['title' => __('Title')];
        $errorNo = true;
        foreach ($data as $field => $value) {
            if (in_array($field, array_keys($requiredFields)) && $value == '') {
                $errorNo = false;
                $this->messageManager->addErrorMessage(__('To apply changes you should fill in hidden required "%1" field', $requiredFields[$field]));
            }
        }
        return $errorNo;
    }
}
