<?php

namespace SM\SU\Model\ResourceModel;

use Magento\Framework\Model\AbstractModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use SM\SU\Api\Data\BlogInterface;

class Blog extends AbstractDb
{
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    )
    {
        parent::__construct($context);
    }
    protected function _construct()
    {
        $this->_init('sumup_blog', 'blog_id');
    }

    /**
     * @param AbstractModel $post
     * @return Blog
     */
    protected function _afterLoad(AbstractModel $post)
    {
        /* @var BlogInterface $post */

        $post->setCategoryIds($this->getCategoryIds($post));
        $post->setTagIds($this->getTagIds($post));
        $post->setProductIds($this->getProductIds($post));

        return parent::_afterLoad($post);
    }

        /**
         * @param BlogInterface $model
         *
         * @return array
         */
        private function getCategoryIds(BlogInterface $model)
    {
        $connection = $this->getConnection();

        $select = $connection->select()->from(
            $this->getTable('sumup_blog_category'),
            'category_id'
        )->where(
            'blog_id = ?',
            (int)$model->getId()
        );

        return $connection->fetchCol($select);
    }

        /**
         * @param BlogInterface $model
         *
         * @return array
         */
        private function getTagIds(BlogInterface $model)
    {
        $connection = $this->getConnection();
        $select = $connection->select()->from(
            $this->getTable('sumup_blog_tag'),
            'tag_id'
        )->where(
            'blog_id = ?',
            (int)$model->getId()
        );

        return $connection->fetchCol($select);
    }

        /**
         * @param BlogInterface $model
         *
         * @return array
         */
        private function getProductIds(BlogInterface $model)
    {
        $connection = $this->getConnection();

        $select = $connection->select()->from(
            $this->getTable('sumup_blog_products'),
            'product_id'
        )->where(
            'blog_id = ?',
            (int)$model->getId()
        );
        return $connection->fetchCol($select);
    }

        /**
         * {@inheritdoc}
         */
        protected function _afterSave(AbstractModel $post)
    {
        /* @var BlogInterface $post */
        $this->saveCategoryIds($post);
        $this->saveTagIds($post);
        $this->saveProductIds($post);

        return parent::_afterSave($post);
        }

        /**
         * @param BlogInterface $model
         *
         * @return $this
         */
        private function saveCategoryIds(\SM\SU\Model\Blog $model)
    {
        $connection = $this->getConnection();

        $table = $this->getTable('sumup_blog_category');

        if (!$model->getCategoryIds()) {
            return $this;
        }

        $categoryIds = $model->getCategoryIds();
        $oldCategoryIds = $this->getCategoryIds($model);

        $insert = array_diff($categoryIds, $oldCategoryIds);
        $delete = array_diff($oldCategoryIds, $categoryIds);

        if (!empty($insert)) {
            $data = [];
            foreach ($insert as $categoryId) {
                if (empty($categoryId)) {
                    continue;
                }

                $data[] = [
                    'category_id' => (int)$categoryId,
                    'blog_id' => (int)$model->getId(),
                ];
            }

            if ($data) {
                $connection->insertMultiple($table, $data);
            }
        }

        if (!empty($delete)) {
            foreach ($delete as $categoryId) {
                $where = ['blog_id = ?' => (int)$model->getId(), 'category_id = ?' => (int)$categoryId];
                $connection->delete($table, $where);
            }
        }

        return $this;
    }

        /**
         * @param BlogInterface $model
         *
         * @return $this
         */
        private function saveTagIds(\SM\SU\Model\Blog $model)
    {
        $connection = $this->getConnection();

        $table = $this->getTable('sumup_blog_tag');

        if (!$model->getTagIds()) {
            return $this;
        }

        $tagIds = $model->getTagIds();
        $oldTagIds = $this->getTagIds($model);
        $insert = array_diff($tagIds, $oldTagIds);
        $delete = array_diff($oldTagIds, $tagIds);

        if (!empty($insert)) {
            $data = [];
            foreach ($insert as $tagId) {
                if (empty($tagId)) {
                    continue;
                }
                $data[] = [
                    'tag_id' => (int)$tagId,
                    'blog_id' => (int)$model->getId(),
                ];
            }

//            var_dump($data);
//            die();
            if ($data) {
                $connection->insertMultiple($table, $data);
            }
        }

        if (!empty($delete)) {
            foreach ($delete as $tagId) {
                $where = ['blog_id = ?' => (int)$model->getId(), 'tag_id = ?' => (int)$tagId];
                $connection->delete($table, $where);
            }
        }

        return $this;
    }

        /**
         * @param BlogInterface $model
         *
         * @return $this
         */
        private function saveProductIds(\SM\SU\Model\Blog $model)
    {
        $connection = $this->getConnection();

        $table = $this->getTable('sumup_blog_products');

        if (!$model->getProductIds()) {
            return $this;
        }

        $productIds = $model->getProductIds();
        $oldProductIds = $this->getProductIds($model);


        $insert = array_diff($productIds, $oldProductIds);
        $delete = array_diff($oldProductIds, $productIds);

        if (!empty($insert)) {
            $data = [];
            foreach ($insert as $productId) {
                if (empty($productId)) {
                    continue;
                }
                $data[] = [
                    'product_id' => (int)$productId,
                    'blog_id' => (int)$model->getId(),
                ];
            }

            if ($data) {
                $connection->insertMultiple($table, $data);
            }
        }

        if (!empty($delete)) {
            foreach ($delete as $productId) {
                $where = ['blog_id = ?' => (int)$model->getId(), 'product_id = ?' => (int)$productId];
                $connection->delete($table, $where);
            }
        }

        return $this;
    }
}
