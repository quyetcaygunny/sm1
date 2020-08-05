<?php

namespace SM\SU\Controller\Adminhtml\Blog;

class Save extends \Magento\Backend\App\Action
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
    ) {
        parent::__construct($context);
        $this->_pageFactory = $pageFactory;
        $this->_blogFactory = $blogFactory;
        $this->_messageManager =$messageManager;
        $this->_cacheClearn =$cacheClearn;
    }

    public function execute()
    {
        $arr = $this->getRequest()->getParams();
        $resultRedirect = $this->resultRedirectFactory->create();
        $blog_id = 0;
        if (array_key_exists('blog_id', $arr) && !empty($arr['blog_id'])) {
            $blog_id = $arr['blog_id'];
        }
        if($this->uniqueName($arr['name'], $blog_id)) {
            $this->_messageManager->addErrorMessage('Blog name exist');
            if (array_key_exists('blog_id', $arr)) {
                $resultRedirect->setPath('sumup/blog/edit', ["blog_id"=> $blog_id]);
            } else {
                $resultRedirect->setPath('sumup/blog/edit');
            }
            return $resultRedirect;
        }

        if ($this->validation($arr) == true ) {
            $name = $arr['name'];
            $short_des = $arr['short_description'];
            $des = $arr['description'];
            $status_id = $arr['status'];
            $categories = $arr['category_ids'];
            $products = [];

            $productIds = $this->getRequest()->getParam("blog_form_product_listing");
            if ($productIds != null) {
                foreach ($productIds as $productId) {
                    $products[] = $productId['entity_id'];
                }
            }
            $tags = $arr['tag_ids'] ??[];
            $content = "";
            $publish_date_from = "";
            $publish_date_to = "";
            $thumbnail_path = "";
            $url_key = "";

            if (array_key_exists('publish_date_from', $arr)) {
                $publish_date_from = $arr['publish_date_from'];
            }
            if (array_key_exists('publish_date_to', $arr)) {
                $publish_date_to = $arr['publish_date_to'];
            }
            if (array_key_exists('url_key', $arr)) {
                $url_key = $arr['url_key'];
            }
            if (array_key_exists('thumbnail_path', $arr) && is_array($arr['thumbnail_path'])) {
                $thumbnail_path = $arr['thumbnail_path'][0]['name'];
            }
            $blog =  $this->_blogFactory->create();
            $collection = $blog->getCollection();
            if (array_key_exists('blog_id', $arr) && !empty($arr['blog_id'])) {
                $blog->load($arr['blog_id']);
            }
            $blog->setData("name", $name);
            $blog->setData("short_description", $short_des);
            $blog->setData("description", $des);
            $blog->setData("content", $content);
            $blog->setData("publish_date_from", $publish_date_from);
            $blog->setData("publish_date_to", $publish_date_to);
            $blog->setData("url_key", $url_key);
            $blog->setData("status", $status_id);
            $blog->setData("thumbnail_path", $thumbnail_path);
            $blog->setData("product_ids",$products);
            $blog->setData("category_ids", $categories);
            $blog->setData("tag_ids", $tags);
            $blog->save();

            $this->_messageManager->addSuccessMessage('Save Successfully');
            $resultRedirect->setPath('sumup/blog/edit', ["blog_id"=> $blog_id]);
        } else {
            $this->_messageManager->addErrorMessage('Invalid Input');
            if (array_key_exists('blog_id', $arr)) {
                $resultRedirect->setPath('sumup/blog/edit', ["blog_id"=> $blog_id]);
            } else {
                $resultRedirect->setPath('sumup/blog/edit');
            }
        }

        return $resultRedirect;
    }

    public function validation($arr)
    {
        if (!array_key_exists('name', $arr) || empty($arr['name'])
            || !array_key_exists('short_description', $arr) || empty($arr['short_description']) || !array_key_exists('description', $arr) || empty($arr['description'])) {
            return false;
        }
        if (array_key_exists('publish_date_from', $arr) && array_key_exists('publish_date_to', $arr) && strtotime($arr['publish_date_from']) > strtotime($arr['publish_date_to'])) {
            return false;
        }
        return true;
    }

    public function uniqueName($blogName, $blog_id)
    {
        $blog =  $this->_blogFactory->create();
        $collection = $blog->getCollection();
        foreach ($collection as $item) {
            if ($blogName == $item->getData('name') && $blog_id != $item['blog_id']) {
                return true;
            }
        }
        return false;
    }
}
