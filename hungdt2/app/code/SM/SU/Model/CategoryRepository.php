<?php

namespace SM\SU\Model;

use SM\SU\Api\Data\CategoryInterface;
use SM\SU\Api\Data\CategoryInterfaceFactory;
use SM\SU\Api\CategoryRepositoryInterface;
use SM\SU\Model\Category;
use SM\SU\Model\ResourceModel\Category\CollectionFactory;

class CategoryRepository implements CategoryRepositoryInterface
{
    private $factory;

    private $collectionFactory;

    public function __construct(
        CategoryInterfaceFactory $factory,
        CollectionFactory $collectionFactory
    ) {
        $this->factory           = $factory;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function getCollection()
    {
        return $this->collectionFactory->create();
    }

    /**
     * {@inheritdoc}
     */
    public function get($id)
    {
        /** @var Category $model */
        $model = $this->create();

        $model->getResource()->load($model, $id);

        return $model->getId() ? $model : false;
    }

    /**
     * {@inheritdoc}
     */
    public function create()
    {
        return $this->factory->create();
    }

    /**
     * {@inheritdoc}
     */
    public function delete(CategoryInterface $model)
    {
        /** @var Category $model */
        return $model->getResource()->delete($model);
    }

    /**
     * {@inheritdoc}
     */
    public function save(CategoryInterface $model)
    {
        /** @var Category $model */
        return $model->getResource()->save($model);
    }
}
