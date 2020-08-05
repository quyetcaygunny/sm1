<?php

namespace SM\SU\Model;

use Magento\Framework\Exception\InputException;
use Magento\Framework\Filter\FilterManager;
use SM\SU\Api\Data\BlogInterface;
use SM\SU\Api\Data\BlogInterfaceFactory;
use SM\SU\Api\CategoryRepositoryInterface;
use SM\SU\Api\BlogRepositoryInterface;
use SM\SU\Api\TagRepositoryInterface;
use SM\SU\Model\Blog;
use SM\SU\Model\ResourceModel\Blog\Collection;
use SM\SU\Model\ResourceModel\Blog\CollectionFactory;


class BlogRepository implements BlogRepositoryInterface
{
    private $factory;
    protected $_idFieldName = 'blog_id';
    private $collectionFactory;

    private $tagRepository;

    private $catRepository;

    private $filterManager;

    public function __construct(
        BlogInterfaceFactory $factory,
        CollectionFactory $collectionFactory,
//        TagRepositoryInterface $tagRepository,
        CategoryRepositoryInterface $catRepository,
        FilterManager $filterManager
    ) {
        $this->factory           = $factory;
        $this->collectionFactory = $collectionFactory;
//        $this->tagRepository     = $tagRepository;
        $this->catRepository     = $catRepository;
        $this->filterManager     = $filterManager;
    }

    /**
     * @inheritdoc
     */
    public function getList()
    {
        /** @var Collection $collection */
        $collection = $this->getCollection();

        return $collection->getItems();
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
        /** @var Post $post */
        $post = $this->create();

        $post->getResource()->load($post, $id);

        if ($post->getId()) {
            return $post;
        }

        return false;
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
    public function update($id, BlogInterface $post)
    {
        /** @var Post $model */
        $model = $this->create();
        $model->getResource()->load($model, $id);

        if (!$model->getId()) {
            throw new InputException(__("The post doesn't exist."));
        }

        $json = json_decode(file_get_contents("php://input"));

        foreach ($json->post as $k => $v) {
            $model->setData($k, $post->getData($k));
        }

        $model->getResource()->save($model);

        return $model;
    }

    /**
     * {@inheritdoc}
     */
    public function apiDelete($id)
    {
        /** @var Post $post */
        $post = $this->create();
        $post->getResource()->load($post, $id);

        if (!$post->getId()) {
            throw new InputException(__("The post doesn't exist."));
        }

        $post->getResource()->delete($post);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(BlogInterface $model)
    {
        /** @var Post $model */
        return $model->getResource()->delete($model);
    }

    /**
     * {@inheritdoc}
     */
    public function save(BlogInterface $model)
    {
        if (!$model->getType()) {
            $model->setType(BlogInterface::TYPE_POST);
        }

        if (!$model->getUrlKey()) {
            $model->setUrlKey($this->filterManager->translitUrl($model->getName()));
        }

        if ($model->getTagIds()) {
            $tagsIds = array_filter($model->getTagIds());
            $model->setTagIds($tagsIds);
        }

        if ($model->getCategoryIds()) {
            $categoryIds = array_filter($model->getCategoryIds());
            $model->setCategoryIds($categoryIds);
        }

        /** @var Post $model */
        $model->getResource()->save($model);

        return $model;
    }
}
