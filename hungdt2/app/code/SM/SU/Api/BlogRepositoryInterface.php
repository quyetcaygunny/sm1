<?php

namespace SM\SU\Api;

use Magento\Framework\Exception\StateException;
use SM\SU\Api\Data\BlogInterface;
use SM\SU\Model\ResourceModel\Blog\Collection;

interface BlogRepositoryInterface
{
    /**
     * @return Collection | BlogInterface[]
     */
    public function getCollection();

    /**
     * @return BlogInterface
     */
    public function create();

    /**
     * @param BlogInterface $model
     *
     * @return BlogInterface
     */
    public function save(BlogInterface $model);

    /**
     * @return BlogInterface[]
     */
    public function getList();

    /**
     * @param int $id
     *
     * @return BlogInterface|false
     */
    public function get($id);

    /**
     * @param int $id
     *
     * @return bool
     * @throws StateException
     */
    public function apiDelete($id);

    /**
     * @param int                                   $id
     * @param BlogInterface $post
     *
     * @return BlogInterface
     * @throws StateException
     */
    public function update($id, BlogInterface $post);

    /**
     * @param BlogInterface $model
     *
     * @return bool
     */
    public function delete(BlogInterface $model);
}
