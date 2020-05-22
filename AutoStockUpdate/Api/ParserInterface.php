<?php

namespace DivideByZero\AutoStockUpdate\Api;

/**
 * Interface ParserInterface
 * @package DivideByZero\AutoStockUpdate\Api
 */
interface ParserInterface
{
    /**
     * @param string $stockData
     * @return \Generator
     */
    public function getStocksFromFile(string $stockData) : \Generator;
}
