<?php
namespace DivideByZero\AutoStockUpdate\Api\Data;

use DivideByZero\AutoStockUpdate\Model\DTO\File;

interface SftpResourceInterface
{
    /**
     * @return mixed
     */
    public function open();

    /**
     * @return mixed
     */
    public function close();

    /**
     * @return mixed
     */
    public function chdirStockFile();

    /**
     * @param array $handledExtensions
     * @return mixed
     */
    public function ls(array $handledExtensions);

    /**
     * @param string $fileName
     * @return mixed
     */
    public function getFile(string $fileName) : File;

    /**
     * @param array $file
     * @return mixed
     */
    public function moveToArchive(File $file) : bool;

    /**
     * @param File $file
     * @return bool
     */
    public function delete(File $file) : bool;
}
