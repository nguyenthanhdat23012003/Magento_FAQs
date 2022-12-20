<?php

namespace Bss\FAQs\Model\FAQs\DataProvide\Source;

use Bss\FAQs\Model\FAQs\DataExample;
use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Status
 */
class Status implements OptionSourceInterface
{

    /**
     * @var DataExample
     */
    protected $dataExample;

    /**
     * @param DataExample $dataExample
     */
    public function __construct(DataExample $dataExample)
    {
        $this->dataExample = $dataExample;
    }

    /**
     * Get status options
     */
    public function toOptionArray()
    {
        $availableOptions = $this->dataExample->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
