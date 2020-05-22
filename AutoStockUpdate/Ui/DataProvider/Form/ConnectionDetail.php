<?php

namespace DivideByZero\AutoStockUpdate\Ui\DataProvider\Form;

use DivideByZero\AutoStockUpdate\Model\Resource\Connection\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

/**
 * Class ConnectionDetail
 * @package DivideByZero\AutoStockUpdate\Ui\DataProvider\Form
 */
class ConnectionDetail extends AbstractDataProvider
{
    /**
     * @var array
     */
    protected $loadedData = [];

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collection
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collection,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collection->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        if (!empty($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        /** @var \DivideByZero\AutoStockUpdate\Model\Connection $item */
        foreach ($items as $item) {
            $this->loadedData[$item->getId()] = $item->toArray();
        }

        $data = $this->dataPersistor->get('connection_detail');

        if (!empty($data)) {
            /** @var \DivideByZero\AutoStockUpdate\Model\Connection $connectionDetail */
            $connectionDetail = $this->collection->getNewEmptyItem();
            $connectionDetail->setData($data);
            $this->loadedData[$connectionDetail->getId()] = $connectionDetail->toArray();
            $this->dataPersistor->clear('connection_detail');
        }

        return $this->loadedData;
    }
}
