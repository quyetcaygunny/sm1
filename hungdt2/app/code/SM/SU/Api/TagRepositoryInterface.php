<?php

namespace SM\SU\Api;

use SM\SU\Api\Data\TagInterface;
use SM\SU\Model\ResourceModel\Tag\Collection;

interface TagRepositoryInterface
{
    /**
     * @return Collection | TagInterface[]
     */
    public function getCollection();

    /**
     * @return TagInterface
     */
    public function create();

    /**
     * @param TagInterface $model
     *
     * @return TagInterface
     */
    public function save(TagInterface $model);

    /**
     * @param TagInterface $model
     *
     * @return TagInterface
     */
    public function ensure(TagInterface $model);

    /**
     * @param int $id
     *
     * @return TagInterface|false
     */
    public function get($id);

    /**
     * @param TagInterface $model
     *
     * @return bool
     */
    public function delete(TagInterface $model);
}
