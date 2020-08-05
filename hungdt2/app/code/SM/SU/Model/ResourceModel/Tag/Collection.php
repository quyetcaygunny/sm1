<?php

namespace SM\SU\Model\ResourceModel\Tag;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @return $this
     */
    public function joinPopularity()
    {
        $this->getSelect()
            ->joinLeft(
                ['tag_post' => $this->getTable('sumup_blog_tag')],
                'main_table.tag_id = sumup_tag.tag_id',
                ['popularity' => 'count(sumup_tag.tag_id)']
            )->group('main_table.tag_id');        return $this;
    }

    /**
     * @return $this
     */
    public function addStoreFilter($storeId)
    {
        $this->getSelect()
            ->joinLeft(
                ['store_post' => $this->getTable('mst_blog_store_post')],
                'tag_post.post_id = store_post.post_id'
            )->where("EXISTS (SELECT * FROM `{$this->getTable('mst_blog_store_post')}`
                AS `store_post`
                WHERE tag_post.post_id = store_post.post_id
                AND store_post.store_id in (?))
                OR NOT EXISTS (SELECT * FROM `{$this->getTable('mst_blog_store_post')}`
                AS `store_post`
                WHERE tag_post.post_id = store_post.post_id)", [0, $storeId]);

        return $this;
    }

    /**
     * @return $this
     */
    public function joinNotEmptyFields()
    {
        $select = $this->getSelect();
        $select->joinRight(
            ['article_tag' => $this->getTable('mst_kb_article_tag')],
            'main_table.tag_id = at_tag_id',
            ['ratio' => 'count(main_table.tag_id)']
        )
            ->group('tag_id');

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('SM\SU\Model\Tag', 'SM\SU\Model\ResourceModel\Tag');
    }
}
