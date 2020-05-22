<?php

namespace DivideByZero\AutoStockUpdate\Controller\Adminhtml\Update;


use DivideByZero\AutoStockUpdate\Api\ConnectionRepositoryInterface;
use DivideByZero\AutoStockUpdate\Api\Data\ConnectionInterface;
use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;

/**
 * Class Delete
 * @package DivideByZero\AutoStockUpdate\Controller\Adminhtml\Update
 */
class Delete extends Action
{
    /**
     * @var ConnectionRepositoryInterface
     */
    private $connectionRepository;

    /**
     * Delete constructor.
     * @param Action\Context $context
     * @param ConnectionRepositoryInterface $connectionRepository
     */
    public function __construct(Action\Context $context, ConnectionRepositoryInterface $connectionRepository)
    {
        parent::__construct($context);
        $this->connectionRepository = $connectionRepository;
    }
    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam(ConnectionInterface::ID);

        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            $connection = $this->connectionRepository->get($id);
            $this->connectionRepository->delete($connection);
        }

        return $resultRedirect->setPath('autostock/update/index');
    }
}
