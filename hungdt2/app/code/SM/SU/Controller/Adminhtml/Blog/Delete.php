<?php

namespace SM\SU\Controller\Adminhtml\Blog;

class Delete extends \Magento\Backend\App\Action
{
    protected $_pageFactory;
    protected $_blogFactory;
    protected $_messageManager;
    protected $_cacheClearn;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \SM\SU\Model\BlogFactory $blogFactory,
        \Magento\Framework\Message\ManagerInterface $messageManager,
         \SM\SU\Helper\CacheClearn $cacheClearn
    )
    {
        parent::__construct($context);
        $this->_pageFactory = $pageFactory;
        $this->_blogFactory = $blogFactory;
        $this->_messageManager =$messageManager;
        $this->_cacheClearn =$cacheClearn;
    }

    public function execute()
    {
        $blog_id = $this->getRequest()->getParam('blog_id');
        if(!empty($blog_id))
        {
            $blog = $this->_blogFactory->create();
            $collection = $blog->getCollection();
            $blog->load($blog_id);
//            $collection->deleteBlogCategory($blog_id);
//            $collection->deleteBlogTag($blog_id);
//            $collection->deleteBlogProducts($blog_id);
            $blog->delete();
            $this->_messageManager->addSuccessMessage('Delete Successfully');
        } else {
            $this->_messageManager->addErrorMessage('Blog does not exists');
        }
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('sumup/blog/bloglist');
        return $resultRedirect;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('SM_SU::deleteblog');
    }


}
