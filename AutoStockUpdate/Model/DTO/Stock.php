<?php
namespace DivideByZero\AutoStockUpdate\Model\DTO;

/**
 * Class Stock
 * @package DivideByZero\AutoStockUpdate\Model\DTO
 */
class Stock
{
    /**
     * @var string
     */
    private $sku;
    /**
     * @var string
     */
    private $warehouse;
    /**
     * @var int
     */
    private $qty;

    /**
     * Stock constructor.
     * @param string $sku
     * @param string $warehouse
     * @param int $qty
     */
    public function __construct(string $sku, string $warehouse, int $qty)
    {
        $this->sku = $sku;
        $this->warehouse = $warehouse;
        $this->qty = $qty;
    }

    /**
     * @return string
     */
    public function getSku(): string
    {
        return $this->sku;
    }

    /**
     * @return string
     */
    public function getWarehouse(): string
    {
        return $this->warehouse;
    }

    /**
     * @return int
     */
    public function getQty(): int
    {
        return $this->qty;
    }

    /**
     * @return array
     */
    public function toArray() : array
    {
        return [
            'sku' => $this->getSku(),
            'qty' => $this->getQty(),
            'warehouse' => $this->getWarehouse()
        ];
    }
}
