<?php

namespace SM\SU\Model\Category;

use SM\SU\Api\CategoryRepositoryInterface;
use SM\SU\Api\Data\CategoryInterface;

class Category implements \Magento\Framework\Option\ArrayInterface
{
//    private $_categoryCollectionFactory;
//    protected $categoriesTree;
//    protected $request;
    private $categoryRepository;

    public function __construct(
        CategoryRepositoryInterface $categoryRepository
    ) {
        $this->categoryRepository = $categoryRepository;
    }


    public function toOptionArray()
    {

        $collection = $this->categoryRepository->getCollection();
        $rootId     = $collection->getRootId();
        //die('anh yêu em');
        return [$this->getOptions($rootId)];
        //return [];
    }
    private function getOptions($parentId)
    {
        $category = $this->categoryRepository->get($parentId);

        $data = [
            'label' => $category->getName(),
            'value' => $category->getId(),
        ];

        $collection = $this->categoryRepository->getCollection()
            ->addFieldToFilter(CategoryInterface::PARENT_ID, $category->getId());

        /** @var CategoryInterface $item */
        foreach ($collection as $item) {
            $data['optgroup'][] = $this->getOptions($item->getId());
        }

        return $data;
    }


}
