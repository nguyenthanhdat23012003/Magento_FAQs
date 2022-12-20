<?php

namespace Bss\FAQs\Api\Data;

/**
 *
 */
interface CategoryInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ID = 'id';
    const TITLE = 'title';
    const STATUS = 'status';
    const ICON = 'icon';

    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return int
     */
    public function getStatus();

    /**
     * @return string
     */
    public function getIcon();

    /**
     * @param $id
     * @return int
     */
    public function setId($id);

    /**
     * @param $title
     * @return string
     */
    public function setTitle($title);

    /**
     * @param $status
     * @return int
     */
    public function setStatus($status);

    /**
     * @param $icon
     * @return string
     */
    public function setIcon($icon);

}
