<?php

namespace SM\SU\Model\Source;

class Layout implements \Magento\Framework\Option\ArrayInterface
{
    protected $brandModel;

    public function __construct(\SM\SU\Model\Brand $brandModel)
    {
        $this->brandModel = $brandModel;
    }

    public function toOptionArray()
    {
        $options = array(
            array(
                'label' => __('Default'),
                'value' => 'default'
            ),
            array(
                'label' => __('Owl Carousel'),
                'value' => 'owl_carousel'
            )
        );
        return $options;
    }
}
