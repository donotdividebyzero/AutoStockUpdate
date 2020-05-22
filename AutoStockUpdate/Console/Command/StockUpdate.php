<?php
namespace DivideByZero\AutoStockUpdate\Console\Command;

use DivideByZero\AutoStockUpdate\Api\StockUpdaterInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class StockUpdate
 * @package DivideByZero\AutoStockUpdate\Console\Command
 */
class StockUpdate extends Command
{
    /**
     * @var StockUpdaterInterface
     */
    private $stockUpdater;

    /**
     * StockUpdate constructor.
     * @param StockUpdaterInterface $stockUpdater
     */
    public function __construct(StockUpdaterInterface $stockUpdater)
    {
        parent::__construct('DivideByZero:stock:update');
        $this->stockUpdater = $stockUpdater;
    }

    /**
     *
     */
    protected function configure()
    {
        $this->setDescription('Import stocks via sftp connection');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->stockUpdater->run();
    }
}
