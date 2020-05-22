<?php
namespace DivideByZero\AutoStockUpdate\Api;

/**
 * Interface ParserPoolInterface
 * @package DivideByZero\AutoStockUpdate\Api
 */
interface ParserPoolInterface
{
    /**
     * @param string $extension
     * @return ParserInterface
     */
    public function getByExtension(string $extension) : ParserInterface;

    /**
     * @return array
     */
    public function handledExtensions() : array;
}
