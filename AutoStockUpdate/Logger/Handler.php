<?php
namespace DivideByZero\AutoStockUpdate\Logger;

use Magento\Framework\Filesystem\DriverInterface;
use Magento\Framework\Logger\Handler\Base;

class Handler extends Base
{
    /**
     * Handler constructor.
     * @param DriverInterface $filesystem
     * @param null $filePath
     * @param null $fileName
     * @param null $level
     */
    public function __construct(DriverInterface $filesystem, $filePath = null, $fileName = null, $level = null)
    {
        $this->loggerType = $level;
        $this->fileName = sprintf($fileName, (new \DateTime())->format('Y-m-d'));
        parent::__construct($filesystem, $filePath);
    }

    /**
     * @param array $record
     * @return bool
     */
    public function isHandling(array $record)
    {
        return $record['level'] == $this->level;
    }
}
