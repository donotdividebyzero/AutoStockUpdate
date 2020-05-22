<?php
namespace DivideByZero\AutoStockUpdate\Model\Resource\Connection;

use DivideByZero\AutoStockUpdate\Api\ConnectionDetailsSearchResultInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package DivideByZero\AutoStockUpdate\Model\Resource\Connection
 */
class Collection extends AbstractCollection implements ConnectionDetailsSearchResultInterface
{
    /**
     *
     */
    public function _construct(): void
    {
        $this->_init(
            \DivideByZero\AutoStockUpdate\Model\Connection::class,
            \DivideByZero\AutoStockUpdate\Model\Resource\Connection::class
        );
    }

    /**
     * @var SearchCriteriaInterface
     */
    private $searchCriteria;

    /**
     * Set items list.
     *
     * @param \Magento\Framework\Api\ExtensibleDataInterface[] $items
     *
     * @return $this
     */
    public function setItems(array $items)
    {
        if (!$items) {
            return $this;
        }

        foreach ($items as $item) {
            try {
                $this->addItem($item);
            } catch (\Exception $e) {
            }
        }

        return $this;
    }

    /**
     * Get search criteria.
     *
     * @return SearchCriteriaInterface
     */
    public function getSearchCriteria(): ?SearchCriteriaInterface
    {
        return $this->searchCriteria;
    }

    /**
     * Set search criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     *
     * @return $this
     */
    public function setSearchCriteria(SearchCriteriaInterface $searchCriteria): self
    {
        $this->searchCriteria = $searchCriteria;
        return $this;
    }

    /**
     * Get total count.
     *
     * @return int
     */
    public function getTotalCount(): int
    {
        return $this->getSize();
    }

    /**
     * Set total count.
     *
     * @param int $totalCount
     *
     * @return $this
     */
    public function setTotalCount($totalCount): self
    {
        return $this;
    }
}
