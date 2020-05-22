<?php
namespace DivideByZero\AutoStockUpdate\Model\Parser\Supplier;


class DefaultSupplier implements SupplierInterface
{
    /**
     * @return string
     */
    public function getDelimiter(): ?string
    {
        return null;
    }

    /**
     * @return string
     */
    public function getEnclosure(): ?string
    {
        return null;
    }

    /**
     * @param mixed (csv, xml) $node
     *
     * @return bool
     */
    public function match($node): bool
    {
        return true;
    }
}
