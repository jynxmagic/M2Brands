<?php

namespace Pinpoint\Brands\Command;

use Magento\Framework\Exception\LocalizedException;
use Pinpoint\Brands\Model\Export\Brand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExportBrandsCsv extends Command
{
    const NAME = "brands:export:csv";

    /**
     * @var Brand
     */
    protected $brandExportModel;


    public function __construct(
        Brand $brandExportModel,
        $name = self::NAME
    ) {
        parent::__construct($name);
        $this->brandExportModel = $brandExportModel;
    }

    protected function configure()
    {
        $this->setName(self::NAME);
        $this->setDescription("Export list of brands as csv to base web dir.");
        parent::configure();
    }

    /**
     * @throws LocalizedException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->brandExportModel->export();

        $output->writeln("<info>Brands Exported Successfully.</info>");
    }
}
