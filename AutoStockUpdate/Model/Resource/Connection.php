<?php
namespace DivideByZero\AutoStockUpdate\Model\Resource;

class Connection extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \DivideByZero\AutoStockUpdate\Model\Connection::TABLE_NAME,
            \DivideByZero\AutoStockUpdate\Model\Connection::ID
        );
    }
}
