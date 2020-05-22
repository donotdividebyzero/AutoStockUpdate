<?php

namespace DivideByZero\AutoStockUpdate\Model\Parser\Supplier;


/**
 * Interface SupplierInterface
 *
 * @package DivideByZero\AutoStockUpdate\Model\Parser\Supplier
 */
interface SupplierInterface
{
    /**
     * @param mixed (csv, xml) $node
     *
     * @return bool
     */
    public function match($node): bool;

    /**
     * @return string
     */
    public function getDelimiter(): ?string;

    /**
     * @return string
     */
    public function getEnclosure(): ?string;
}
