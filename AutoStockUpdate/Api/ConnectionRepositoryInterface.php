<?php

namespace DivideByZero\AutoStockUpdate\Api;

use DivideByZero\AutoStockUpdate\Api\Data\ConnectionInterface;
use Magento\Framework\Api\Search\SearchCriteria;
use Magento\Framework\Data\SearchResultInterface;

/**
 * Interface ConnectionRepositoryInterface
 * @package DivideByZero\AutoStockUpdate\Api
 */
interface ConnectionRepositoryInterface
{
    /**
     * @param int $id
     * @return ConnectionInterface
     */
    public function get(int $id): ConnectionInterface;

    /**
     * @param ConnectionInterface $connection
     * @return ConnectionInterface
     */
    public function save(ConnectionInterface $connection): ConnectionInterface;

    /**
     * @param ConnectionInterface $connection
     * @return bool
     */
    public function delete(ConnectionInterface $connection): bool;

    /**
     * @param SearchCriteria $searchCriteria
     * @return array
     */
    public function getList(SearchCriteria $searchCriteria): SearchResultInterface;
}
