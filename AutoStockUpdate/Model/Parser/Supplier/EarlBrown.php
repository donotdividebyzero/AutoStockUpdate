<?php
namespace DivideByZero\AutoStockUpdate\Model\Parser\Supplier;

class EarlBrown implements SupplierInterface
{

    /**
     * @return string
     */
    public function getDelimiter(): ?string
    {
        return ';';
    }

    /**
     * @return string
     */
    public function getEnclosure(): ?string
    {
        return "'";
    }

    /**
     * @param mixed (csv, xml) $node
     *
     * @return bool
     */
    public function match($node): bool
    {
        return strpos($node, ';') !== false;
    }
}
