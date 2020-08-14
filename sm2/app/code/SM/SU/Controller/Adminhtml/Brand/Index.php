<?php

namespace SM\SU\Controller\Adminhtml\Brand;

class Index extends \SM\SU\Controller\Adminhtml\Brand
{
    public function execute()
    {
        //die('dit cu m');
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('MGS_Brand::manage_brand');
        $resultPage->getConfig()->getTitle()->prepend(__('Manage Brands'));
        $resultPage->addBreadcrumb(__('Shop By Brand'), __('Shop By Brand'));
        $resultPage->addBreadcrumb(__('Manage Brands'), __('Manage Brands'));
        return $resultPage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('SM_::manage_brand');
    }
}
