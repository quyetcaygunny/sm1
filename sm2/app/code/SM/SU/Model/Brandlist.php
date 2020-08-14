<?php
namespace SM\SU\Model;

class Brandlist extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    /**
     * to option array
     *
     * @return array
     */
    public function getAllOptions()
    {
        $_objManager = \Magento\Framework\App\ObjectManager::getInstance();
        $brandData = $_objManager->create('SM\SU\Model\Brand')->getCollection();
        $options = array();
        $options[] =[
            'value' => '',
            'label' => __('-- Please Select --')
        ];
        foreach($brandData as $_brand){
            $options[] =  [
                'value' => $_brand->getId(),
                'label' => __($_brand->getName())
            ];
        }
        return $options;

    }

    public function toOptionArray()
    {
        $_objManager = \Magento\Framework\App\ObjectManager::getInstance();
        $brandData = $_objManager->create('SM\SU\Model\Brand')->getCollection();
        $options = array();
        $options[] =[
            'value' => '',
            'label' => __('-- Please Select --')
        ];
        foreach($brandData as $_brand){
            $options[] =  [
                'value' => $_brand->getId(),
                'label' => __($_brand->getName())
            ];
        }
        return $options;

    }
}
