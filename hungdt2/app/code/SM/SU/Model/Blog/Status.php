<?php

namespace SM\SU\Model\Blog;

class Status implements \Magento\Framework\Option\ArrayInterface
{

    public function toOptionArray()
    {

        return [
            [
                'label' => __('Enable'),
                'value' => '0',
            ],
            [
                'label' => __('Disable'),
                'value' => '1',
            ],

        ];
    }
}
