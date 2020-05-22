<?php
namespace DivideByZero\AutoStockUpdate\Model\Parser;

use DivideByZero\AutoStockUpdate\Api\ParserInterface;
use DivideByZero\AutoStockUpdate\Model\DTO\Stock;

class Csv implements ParserInterface
{
    /**
     * @var SupplierConfigPool
     */
    private $supplierConfigPool;

    /**
     * Csv constructor.
     *
     * @param SupplierConfigPool $supplierConfigPool
     */
    public function __construct(SupplierConfigPool $supplierConfigPool)
    {
        $this->supplierConfigPool = $supplierConfigPool;
    }

    /**
     * @param string $stockData
     * @return \Generator
     */
    public function getStocksFromFile(string $stockData) : \Generator
    {
        $lines = array_filter(explode(PHP_EOL, $stockData));

        foreach ($lines as $line) {
            $supplierConfig = $this->supplierConfigPool->getByNode($line);
            $fields = str_getcsv($line, $supplierConfig->getDelimiter(), $supplierConfig->getEnclosure());

            if(array_search('sku', $fields) === false) {
                $qty = (int)preg_replace("/\s+/", '', $fields[2]);

                yield new Stock($fields[0], $fields[1], $qty);
            }
        }

        return null; //end of generator
    }
}
