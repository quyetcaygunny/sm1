<?php

namespace SM\SU\Model\Source;

class Countries implements \Magento\Framework\Option\ArrayInterface
{
    protected $_countryCollectionFactory;

    public function __construct( \Magento\Directory\Model\ResourceModel\Country\CollectionFactory $countryCollectionFactory)
    {
        $this->_countryCollectionFactory = $countryCollectionFactory;
    }

    public function toOptionArray()
    {
        $options = [];
        foreach ($this->getCountryname() as $value => $country) {
            $options[] = [
                'value' => $value,
                'label' => $country->getName()
            ];
        }
        return $options;
    }

    public function getCountryname()
    {
        return $this->_countryCollectionFactory->create()->loadByStore();
    }
}
