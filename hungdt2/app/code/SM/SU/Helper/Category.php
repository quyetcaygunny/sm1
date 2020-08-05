<?php

namespace SM\SU\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use SM\SU\Model\ResourceModel\Category\CollectionFactory;

class Category extends AbstractHelper
{

    /**
     * @param CollectionFactory $categoryCollectionFactory
     * @param Context                         $context
     */
    protected $categoryCollectionFactory;
    public function __construct(
        CollectionFactory $categoryCollectionFactory,
        Context $context
    ) {
        $this->categoryCollectionFactory = $categoryCollectionFactory;

        parent::__construct($context);
    }

    /**
     * @return \SM\SU\Model\Category|false
     */
    public function getRootCategory()
    {
        $category   = false;
        $collection = $this->categoryCollectionFactory->create()
            ->addFieldToFilter('parent_id', 0);

        if ($collection->count()) {
            $category = $collection->getFirstItem();
        }

        return $category;
    }
}
