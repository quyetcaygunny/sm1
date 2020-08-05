<?php

namespace SM\SU\Api\Data;

interface TagInterface
{
    const ID = 'tag_id';

    const TABLE = 'sumup_tag';

    const NAME    = 'tag_name';


    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getUrlKey();

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setUrlKey($value);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setName($value);
}
