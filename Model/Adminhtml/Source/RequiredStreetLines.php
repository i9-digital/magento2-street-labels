<?php

namespace I9\StreetLabel\Model\Adminhtml\Source;

class RequiredStreetLines implements \Magento\Framework\Data\OptionSourceInterface {

    public function toOptionArray()
    {
        return [
            [
                'value' => '0',
                'label' => __('Only line 1')
            ],
            [
                'value' => '0,1',
                'label' => __('Lines 1 and 2')
            ],
            [
                'value' => '0,1,2',
                'label' => __('Lines 1 and 2 and 3')
            ],
            [
                'value' => '0,1,2,3',
                'label' => __('All lines')
            ]
        ];
    }
}
