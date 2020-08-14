<?php

namespace SM\SU\Block\Adminhtml;

class Brand extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_controller = 'adminhtml_brand';
        $this->_blockGroup = 'SM_SU';
        $this->_headerText = __('Manage Brands');
        $this->_addButtonLabel = __('Add New Brand');
        parent::_construct();
    }
}
