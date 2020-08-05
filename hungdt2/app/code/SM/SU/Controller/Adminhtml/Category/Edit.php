<?php

namespace SM\SU\Controller\Adminhtml\Category;

class Edit extends \Magento\Backend\App\Action
{
    protected $resultPageFactory = false;

    private $registry;

    private $categoryFactory;


    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \SM\SU\Model\CategoryFactory $categoryFactory,
        \Magento\Framework\Registry $registry
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->categoryFactory = $categoryFactory;
        $this->registry = $registry;
    }

    public function execute()
    {


        $categoryModel= $this->categoryFactory->create();

        $id = $this->getRequest()->getParam('category_id');
        //die($id);
        if($id)
        {

            $categoryModel->load($id);
            if(!$categoryModel->getId()){
                $resultRedirect =  $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('sumup/category/categorylist');
            }
        }

        $this->registry->register('sumup_category',$categoryModel);

        $resultPage =$this->resultPageFactory->create();
        $resultPage->getConfig()->setKeywords(__('Edit Page'));

        $resultPage->setActiveMenu('SM_SU::menu');

        $pageTitltPrefix = __('%1',
            $categoryModel->getId()?$categoryModel->getData('category_name'): __('New Category')
        );
        $resultPage->getConfig()->getTitle()->prepend($pageTitltPrefix);
        return $resultPage;
    }
}
