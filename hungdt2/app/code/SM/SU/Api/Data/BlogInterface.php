<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace SM\SU\Api\Data;


interface BlogInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const BLOG_ID = 'blog_id';
    const NAME = 'name';
    const SHORT_DESCRIPTION = 'short_description';
    const DESCRIPTION = 'description';
    const STATUS = 'status';
    const THUMBNAIL = 'thumbnail_path';
    const PUBLISH_DATE_FROM = 'publish_date_from';
    const PUBLISH_DATE_TO = 'publish_date_to';
    const URL_KEY = 'url_key';

    const TYPE_REVISION = 'revision';
    const CATEGORY_IDS = 'category_ids';
    const TAG_IDS      = 'tag_ids';
    const PRODUCT_IDS  = 'product_ids';

    /**#@-*/

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * Get short description
     *
     * @return string|null
     */
    public function getShortDescription();

    /**
     * Get description
     *
     * @return string|null
     */
    public function getDescription();

    /**
     * Get status
     *
     * @return bool|null
     */
    public function getStatus();

    /**
     * Get thumbnail
     *
     * @return bool|null
     */
    public function getThumbnail();

    /**
     * Get publish date from
     *
     * @return string|null
     */
    public function getPublishDateFrom();

    /**
     * Get publish date to
     *
     * @return bool|null
     */
    public function getPublishDateTo();

    /**
     * get url_key
     *
     * @return bool|null
     */
    public function getUrlKey();

    /**
     * Set ID
     *
     * @param int $id
     * @return BlogInterface
     */
    public function setId($id);

    /**
     * Set identifier
     *
     * @param $name
     * @return BlogInterface
     */
    public function setName($name);

    /**
     * Set short description
     *
     * @param $shortDescription
     * @return BlogInterface
     */
    public function setShortDescription($shortDescription);

    /**
     * Set description
     *
     * @param $description
     * @return BlogInterface
     */
    public function setDescription($description);

    /**
     * Set status
     *
     * @param $status
     * @return BlogInterface
     */
    public function setStatus($status);

    /**
     * Set thumbnail
     *
     * @param $thumbnail
     * @return BlogInterface
     */
    public function setThumbnail($thumbnail);

    /**
     * Set publish date from
     *
     * @param $publishDateFrom
     * @return BlogInterface
     */
    public function setPublishDateFrom($publishDateFrom);

    /**
     * Set publish date to
     *
     * @param $publishDateTo
     * @return BlogInterface
     */
    public function setPublishDateTo($publishDateTo);

    /**
     * Set url key
     *
     * @param $urlKey
     * @return BlogInterface
     */
    public function setUrlKey($urlKey);

    /**
     * @return mixed
     */
    public function getCategoryIds();

    /**
     * @param mixed $value
     *
     * @return $this
     */
    public function setCategoryIds(array $value);


    /**
     * @return mixed
     */
    public function getTagIds();

    /**
     * @param mixed $value
     *
     * @return $this
     */
    public function setTagIds(array $value);

    /**
     * @return mixed
     */
    public function getProductIds();

    /**
     * @param mixed $value
     *
     * @return $this
     */
    public function setProductIds(array $value);

    /**
     * @return mixed|Collection
     */
    public function getRelatedProducts();
}
