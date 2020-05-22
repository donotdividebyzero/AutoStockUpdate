<?php

namespace DivideByZero\AutoStockUpdate\Model;


use DivideByZero\AutoStockUpdate\Api\ConnectionDetailsSearchResultInterface;
use DivideByZero\AutoStockUpdate\Api\ConnectionRepositoryInterface;
use DivideByZero\AutoStockUpdate\Api\Data\ConnectionInterface;
use DivideByZero\AutoStockUpdate\Api\Data\ConnectionInterfaceFactory;
use Magento\Framework\Api\Search\SearchCriteria;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Data\SearchResultInterface;
use Magento\Framework\EntityManager\EntityManager;

/**
 * Class ConnectionRepository
 * @package DivideByZero\AutoStockUpdate\Model
 */
class ConnectionRepository implements ConnectionRepositoryInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;
    /**
     * @var ConnectionInterfaceFactory
     */
    private $connectionInterfaceFactory;
    /**
     * @var ConnectionDetailsSearchResultInterface
     */
    private $searchResultFactory;

    /**
     * ConnectionRepository constructor.
     * @param EntityManager $entityManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param ConnectionInterfaceFactory $connectionInterfaceFactory
     * @param ConnectionDetailsSearchResultInterface $searchResultFactory
     */
    public function __construct(
        EntityManager $entityManager,
        CollectionProcessorInterface $collectionProcessor,
        ConnectionInterfaceFactory $connectionInterfaceFactory,
        ConnectionDetailsSearchResultInterface $searchResultFactory
    )
    {
        $this->entityManager = $entityManager;
        $this->collectionProcessor = $collectionProcessor;
        $this->connectionInterfaceFactory = $connectionInterfaceFactory;
        $this->searchResultFactory = $searchResultFactory;
    }

    /**
     * @param int $id
     * @return ConnectionInterface
     */
    public function get(int $id): ConnectionInterface
    {
        $connection = $this->connectionInterfaceFactory->create();
        return $connection->load($id);
    }

    /**
     * @param ConnectionInterface $connection
     * @return ConnectionInterface
     */
    public function save(ConnectionInterface $connection): ConnectionInterface
    {
        try {
            return $this->entityManager->save($connection);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param ConnectionInterface $connection
     * @return bool
     */
    public function delete(ConnectionInterface $connection): bool
    {
        try {
            return $this->entityManager->delete($connection);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param SearchCriteria $searchCriteria
     * @return array
     */
    public function getList(SearchCriteria $searchCriteria): SearchResultInterface
    {
        /** @var  SearchResultsInterface | AbstractDB $searchResult */
        $searchResult = $this->searchResultFactory->create();
        $this->collectionProcessor->process($searchCriteria, $searchResult);
        $searchResult->setSearchCriteria($searchCriteria);
        return $searchResult;
    }
}
