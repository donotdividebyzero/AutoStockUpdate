<?php

namespace DivideByZero\AutoStockUpdate\Model\Parser;


use DivideByZero\AutoStockUpdate\Model\Parser\Supplier\SupplierInterface;

class SupplierConfigPool
{
    /**
     * @var array
     */
    private $suppliers;

    /**
     * SupplierConfigPool constructor.
     *
     * @param array $suppliers
     */
    public function __construct(array $suppliers)
    {
        $this->suppliers = $suppliers;
    }

    /**
     * @param mixed (csv, xml values possible) $node
     *
     * @return SupplierInterface
     */
    public function getByNode($node): SupplierInterface
    {
        /** @var  SupplierInterface $supplier */
        foreach($this->suppliers as $supplier) {
            if ($supplier->match($node)) {
                return $supplier;
            }
        }
    }
}
