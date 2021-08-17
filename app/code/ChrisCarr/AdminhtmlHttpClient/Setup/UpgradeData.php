<?php

namespace ChrisCarr\AdminhtmlHttpClient\Setup;

use ChrisCarr\AdminhtmlHttpClient\Block\Index;
use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\CategoryFactory;
use Magento\Catalog\Model\CategoryRepository;
use Magento\Cms\Model\Block;
use Magento\Cms\Model\BlockFactory;
use Magento\Cms\Model\BlockRepository;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;

class UpgradeData implements UpgradeDataInterface
{

    protected const BLOCK_TEMPLATE = "ChrisCarr_AdminhtmlHttpClient::index.phtml";

    protected $blockFactory;
    protected $blockRepository;

    protected $categoryFactory;
    protected $categoryRepository;

    public function __construct(
        BlockFactory       $blockFactory,
        BlockRepository    $blockRepository,
        CategoryFactory    $categoryFactory,
        CategoryRepository $categoryRepository
    ) {
        $this->blockFactory = $blockFactory;
        $this->blockRepository = $blockRepository;
        $this->categoryFactory = $categoryFactory;
        $this->categoryRepository = $categoryRepository;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {

        $setup->startSetup();

        if (version_compare($context->getVersion(), '2.0.5') < 0) {
            try {
                $this->createBlock();
                $this->createCategory();
            } catch (CouldNotSaveException $e) {
                echo $e->getMessage();
            }
        }

        $setup->endSetup();
    }

    /**
     * @throws CouldNotSaveException
     */
    private function createBlock()
    {
        /**
         * @var Block $block
         */
        $block = $this->blockFactory->create();

        $block->setTitle("Harry Potter Characters");
        $block->setIdentifier("harry-potter-chars");
        $block->setStoreId(0);
        $block->setIsActive(1);
        $block->setContent(
            sprintf(
                '{{block class="%s" template="%s"}}',
                Index::class,
                self::BLOCK_TEMPLATE
            )
        );

        $this->blockRepository->save($block);
    }

    /**
     * @throws CouldNotSaveException
     */
    private function createCategory()
    {
        /**
         * @var Category $category
         */
        $category = $this->categoryFactory->create();

        $category->setName("Harry Potter Characters");
        $category->setIsActive(true);
        $category->setUrlKey("harry-potter-characters-list");
        $category->setData("display_mode", "PAGE");
        $category->setData("landing_page", 1);
        $category->setData("description", "An example page to show Adminhtmlhttpclient
                    is installed and configured correctly.");

        $this->categoryRepository->save($category);
    }
}
