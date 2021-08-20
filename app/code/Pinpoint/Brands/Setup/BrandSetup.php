<?php

namespace Pinpoint\Brands\Setup;

use Magento\Eav\Setup\EavSetup;
use Pinpoint\Brands\Model\ResourceModel\Brand;

class BrandSetup extends EavSetup
{
    public function getDefaultEntities()
    {
        $entity = "brand_entity";

        $entities = [
            $entity => [
                "entity_model" => Brand::class,
                "table" => "brand_entity",
                "attributes" => [
                    "title" => [
                        "type" => "static"
                    ]
                ]
            ]
        ];

        return $entities;
    }
}
