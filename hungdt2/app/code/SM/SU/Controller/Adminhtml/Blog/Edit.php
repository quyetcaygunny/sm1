<?php

namespace SM\SU\Controller\Adminhtml\Blog;

class Edit extends \Magento\Backend\App\Action
{
    protected $resultPageFactory = false;

    private $registry;

    private $blogFactory;


    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \SM\SU\Model\BlogFactory $BlogFactory,
        \Magento\Framework\Registry $registry
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->blogFactory = $BlogFactory;
        $this->registry = $registry;
    }

    public function execute()
    {


        $blogModel= $this->blogFactory->create();

        $id = $this->getRequest()->getParam('post_id');
        //die($id);
        if($id)
        {

            $blogModel->load($id);
            if(!$blogModel->getId()){
                $resultRedirect =  $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('sumup/blog/index');
            }
        }

        $this->registry->register('sumup_blog',$blogModel);

        $resultPage =$this->resultPageFactory->create();
        $resultPage->getConfig()->setKeywords(__('Edit Page'));

//        $resultPage->setActiveMenu('SM_SU::menu');

        $pageTitltPrefix = __('%1',
            $blogModel->getId()?$blogModel->getData('name'): __('New Blog')
        );
        $resultPage->getConfig()->getTitle()->prepend($pageTitltPrefix);
        return $resultPage;
    }
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('SM_SU::createblog');
    }
}
