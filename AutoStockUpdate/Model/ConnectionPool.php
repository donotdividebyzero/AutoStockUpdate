<?php

namespace DivideByZero\AutoStockUpdate\Model;


use DivideByZero\AutoStockUpdate\Model\Connection\FromAdminConnection;

class ConnectionPool
{
    /**
     * @var FromAdminConnection
     */
    private $defaultConnection;

    /**
     * @var Resource\Connection\CollectionFactory
     */
    private $collectionFactory;

    /**
     * ConnectionPool constructor.
     * @param FromAdminConnection $defaultConnection
     * @param Resource\Connection\CollectionFactory $collectionFactory
     */
    public function __construct(
        FromAdminConnection $defaultConnection,
        Resource\Connection\CollectionFactory $collectionFactory
    )
    {
        $this->defaultConnection = $defaultConnection;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @return array
     */
    public function getPool(): array
    {
        $collection = $this->collectionFactory->create()->getItems();

        if (count($collection)) {
            return $collection;
        }

        return [$this->defaultConnection];
    }
}
