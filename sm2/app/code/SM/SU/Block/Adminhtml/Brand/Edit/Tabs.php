<?php

namespace SM\SU\Block\Adminhtml\Brand\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    protected function _construct()
    {
        parent::_construct();
        $this->setId('brand_edit_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Brand'));
    }

    protected function _prepareLayout()
    {
        $this->addTab(
            'general',
            [
                'label' => __('Brand Information'),
                'content' => $this->getLayout()->createBlock('SM\SU\Block\Adminhtml\Brand\Edit\Tab\Main')->toHtml()
            ]
        );

        $this->addTab(
            'products',
            [
                'label' => __('Products'),
                'url' => $this->getUrl('sumup/*/products', ['_current' => true]),
                'class' => 'ajax'
            ]
        );
    }
}
