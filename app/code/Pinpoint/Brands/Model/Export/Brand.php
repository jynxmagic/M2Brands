<?php

namespace Pinpoint\Brands\Model\Export;

use Magento\Eav\Model\Config;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem;
use Pinpoint\Brands\Api\BrandRepositoryInterface;

class Brand
{

    protected const FILENAME = "logo_list.csv";
    protected $brandRepository;
    protected $fs;
    protected $directory;
    protected $eavConfig;
    protected $attributeCollection;

    public function __construct(
        BrandRepositoryInterface $brandRepository,
        Filesystem               $fs,
        Config                   $eavConfig
    ) {
        $this->eavConfig = $eavConfig;
        $this->brandRepository = $brandRepository;
        $this->fs = $fs;
        $this->directory = $fs->getDirectoryWrite(DirectoryList::PUB);
    }

    /**
     * @throws LocalizedException
     */
    public function export()
    {
        set_time_limit(0); //increase php_timeout, could be many entries to write

        $this->directory->create("export");
        $fsOutputStream = $this->directory->openFile("export/" . self::FILENAME, "w+");
        $fsOutputStream->lock();

        $columns = ["title", "desktop_image", "mobile_image", "brand_category"]; //TODO dynamc attrs

        $fsOutputStream->writeCsv($columns);

        $brandCollection = $this->_getEntityCollection();

        $i = 0;
        $c = count($brandCollection);
        foreach ($brandCollection as $brand) {
            $i++;
            echo "Exporting $i of $c..." . PHP_EOL;
            $item = [];
            foreach ($columns as $attribute) {
                $item[] = $brand->getData($attribute);
            }
            $fsOutputStream->writeCsv($item);

        }

        $fsOutputStream->close();
    }

    protected function _getEntityCollection()
    {
        $this->_entityCollection = $this->brandRepository->getUnfilteredList();
        return $this->_entityCollection;
    }
}
