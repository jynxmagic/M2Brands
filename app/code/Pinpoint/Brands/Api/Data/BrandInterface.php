<?php

namespace Pinpoint\Brands\Api\Data;

interface BrandInterface
{
    /**
     * @return int
     */
    public function getEntityId();

    /**
     * @param int $data
     * @return void
     */
    public function setEntityId($data);

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @param string $data
     * @return void
     */
    public function setTitle($data);

    /**
     * @return string
     */
    public function getDescription();

    /**
     * @param string $data
     * @return void
     */
    public function setDescription($data);

    /**
     * @return string
     */
    public function getAltText();

    /**
     * @param string $data
     * @return void
     */
    public function setAltText($data);

    /**
     * @return string
     */
    public function getDesktopImage();

    /**
     * @param string $data
     * @return void
     */
    public function setDesktopImage($data);

    /**
     * @return string
     */
    public function getMobileImage();

    /**
     * @param string $data
     * @return void
     */
    public function setMobileImage($data);

    /**
     * @param bool $data
     */
    public function setEnabled($data);

    /**
     * @return bool
     */
    public function getEnabled();
}
