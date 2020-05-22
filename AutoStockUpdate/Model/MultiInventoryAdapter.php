<?php

namespace DivideByZero\AutoStockUpdate\Model;

use Amasty\MultiInventory\Api\Data\WarehouseItemApiInterfaceFactory;
use Amasty\MultiInventory\Api\Data\WarehouseItemInterface;
use Amasty\MultiInventory\Api\WarehouseItemRepositoryInterface;
use DivideByZero\AutoStockUpdate\Model\DTO\Stock;

/**
 * Class MultiInventoryAdapter
 * @package DivideByZero\AutoStockUpdate\Model
 */
class MultiInventoryAdapter
{
    /**
     * @var WarehouseItemApiInterfaceFactory
     */
    private $warehouseItemFactory;

    /**
     * @var WarehouseItemRepositoryInterface
     */
    private $warehouseItemRepository;

    /**
     * MultiInventoryAdapter constructor.
     * @param WarehouseItemApiInterfaceFactory $warehouseItemFactory
     * @param WarehouseItemRepositoryInterface $warehouseItemRepository
     */
    public function __construct(
        WarehouseItemApiInterfaceFactory $warehouseItemFactory,
        WarehouseItemRepositoryInterface $warehouseItemRepository
    )
    {
        $this->warehouseItemFactory = $warehouseItemFactory;
        $this->warehouseItemRepository = $warehouseItemRepository;
    }


    /**
     * @param Stock $data
     * @return WarehouseItemInterface
     */
    public function addStock(Stock $data) : WarehouseItemInterface
    {
        /** @var \Amasty\MultiInventory\Api\Data\WarehouseItemApiInterface $stock */
        $stock = $this->warehouseItemFactory->create();
        $stock->setCode($data->getWarehouse());
        $stock->setQty($data->getQty());
        $stock->setSku($data->getSku());

        return $this->warehouseItemRepository->addStockSku($stock);
    }
}
