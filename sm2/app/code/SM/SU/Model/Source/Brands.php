<?php

namespace SM\SU\Model\Source;

class Brands implements \Magento\Framework\Option\ArrayInterface
{
    protected $brandModel;

    public function __construct(\SM\SU\Model\Brand $brandModel)
    {
        $this->brandModel = $brandModel;
    }

    public function toOptionArray()
    {
        $options = [];
        $brands = $this->brandModel->getCollection()
            ->addFieldToFilter('status', '1');
        foreach ($brands as $brand) {
            $options[] = [
                'label' => $brand->getName(),
                'value' => $brand->getId(),
            ];
        }
        return $options;
    }
}
