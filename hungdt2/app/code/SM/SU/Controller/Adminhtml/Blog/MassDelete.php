<?php

namespace SM\SU\Controller\Adminhtml\Blog;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use SM\SU\Model\ResourceModel\Blog\CollectionFactory;
use SM\SU\Api\BlogRepositoryInterface;

class MassDelete extends Action
{
    protected $filter;

    protected $collectionFactory;
    private $postRepository;

    public function __construct(Context $context, Filter $filter,  BlogRepositoryInterface $postRepository)
    {
        $this->filter            = $filter;
        $this->postRepository = $postRepository;
        parent::__construct($context);
    }

    public function execute()
    {
        //die('anh yêu em ');
        $blogCollection = $this->postRepository->getCollection();
        $collection     = $this->filter->getCollection($blogCollection);
        $collectionSize = $collection->getSize();

        foreach ($collection as $item) {
            $item->delete();
        }

        $this->messageManager->addSuccess(__('A total of %1 post(s) have been deleted.', $collectionSize));

        /**
         * @var Redirect $resultRedirect
         */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/');
    }
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('SM_SU::massdeleteblog');
    }
}
