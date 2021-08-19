<?php

namespace Pinpoint\Brands\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface BrandInterface extends ExtensibleDataInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     * @return void
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @param string $title
     * @return void
     */
    public function setTitle($title);

    /**
     * @return BrandExtensionInterface | null
     */
    public function getExtensionAttributes();

    /**
     * @param BrandExtensionInterface $extensionAttributes
     */
    public function setExtensionAttributes(BrandExtensionInterface $extensionAttributes);
}
