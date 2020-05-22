<?php

namespace DivideByZero\AutoStockUpdate\Model;

use DivideByZero\AutoStockUpdate\Api\Data\ConnectionInterface;
use DivideByZero\AutoStockUpdate\Api\Data\SftpResourceInterface;
use DivideByZero\AutoStockUpdate\Api\Data\SftpResourceInterfaceFactory;
use DivideByZero\AutoStockUpdate\Api\ParserInterface;
use DivideByZero\AutoStockUpdate\Api\ParserPoolInterface;
use DivideByZero\AutoStockUpdate\Api\StockUpdaterInterface;
use DivideByZero\AutoStockUpdate\Model\DTO\File;
use Magento\Framework\App\State;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;

/**
 * Class Updater
 * @package DivideByZero\AutoStockUpdate\Model
 */
class Updater implements StockUpdaterInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var MultiInventoryAdapter
     */
    private $multiInventoryAdapter;

    /**
     * @var ParserPoolInterface
     */
    private $parserPool;

    /**
     * @var ConnectionPool
     */
    private $connectionPool;
    /**
     * @var SftpResourceInterfaceFactory
     */
    private $sftpResourceInterfaceFactory;
    /**
     * @var State
     */
    private $appState;

    /**
     * Updater constructor.
     * @param State $appState
     * @param ConnectionPool $connectionPool
     * @param LoggerInterface $logger
     * @param ParserPoolInterface $parserPool
     * @param MultiInventoryAdapter $multiInventoryAdapter
     * @param SftpResourceInterfaceFactory $sftpResourceInterfaceFactory
     */
    public function __construct(
        State $appState,
        ConnectionPool $connectionPool,
        LoggerInterface $logger,
        ParserPoolInterface $parserPool,
        MultiInventoryAdapter $multiInventoryAdapter,
        SftpResourceInterfaceFactory $sftpResourceInterfaceFactory
    )
    {
        $this->logger = $logger;
        $this->parserPool = $parserPool;
        $this->multiInventoryAdapter = $multiInventoryAdapter;
        $this->connectionPool = $connectionPool;
        $this->sftpResourceInterfaceFactory = $sftpResourceInterfaceFactory;
        $this->appState = $appState;
    }

    /**
     *
     */
    public function run()
    {
        try {
            $this->appState->setAreaCode('adminhtml');
        } catch (LocalizedException $e) {
            //exception is thrown when area code is already set.
        }

        foreach($this->connectionPool->getPool() as $connection) {
            $sftp = $this->sftpResourceInterfaceFactory->create(['connectionDetails' => $connection]);
            try {
                $sftp = $this->init($sftp);
                $list = $this->getFileList($sftp);

                foreach ($list as $file) {
                    try {
                        $fileModel = $sftp->getFile($file);
                        $this->updateStock($fileModel);

                        if ($sftp->moveToArchive($fileModel)) {
                            $sftp->delete($fileModel);
                        }
                    } catch (\Exception $e) {
                        $this->logger->error(__("Error during connection: %1", $e->getMessage()));
                    }
                }
            } catch (\Exception $e) {
                $this->logger->error(__("Error: %1", $e->getMessage()));
            } finally {
                $sftp->close();
            }
        }
    }

    /**
     * @param SftpResourceInterface $sftp
     */
    private function init(SftpResourceInterface $sftp) : SftpResourceInterface
    {
        $sftp->open();
        $sftp->chdirStockFile();
        return $sftp;
    }

    /**
     * @param File $file
     */
    private function updateStock(File $file)
    {
        /** @var ParserInterface $parser */
        $parser = $this->parserPool->getByExtension($file->getExtension());

        foreach ($parser->getStocksFromFile($file->getContent()) as $stock) {
            try {
                if ($stock !== null) {
                    $this->multiInventoryAdapter->addStock($stock);
                    $this->logger->debug(print_r($stock->toArray(), true));
                }
            } catch(CouldNotSaveException $e) {
                $this->logger->error(sprintf("%s: %s", $e->getMessage(), $stock->getSku()));
            } catch (\Exception $e) {
                $this->logger->error($e->getMessage());
            }
        }
    }

    private function getFileList(SftpResourceInterface $sftp)
    {
        $list = $sftp->ls($this->parserPool->handledExtensions());
        natsort($list); // sort by date timestamp in name

        return $list;
    }
}
