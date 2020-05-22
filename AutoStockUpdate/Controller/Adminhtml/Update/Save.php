<?php
namespace DivideByZero\AutoStockUpdate\Controller\Adminhtml\Update;


use DivideByZero\AutoStockUpdate\Api\ConnectionRepositoryInterface;
use DivideByZero\AutoStockUpdate\Api\Data\ConnectionInterface;
use DivideByZero\AutoStockUpdate\Api\Data\ConnectionInterfaceFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;

/**
 * Class Save
 * @package DivideByZero\AutoStockUpdate\Controller\Adminhtml\Update
 */
class Save extends Action
{
    /**
     * @var ConnectionInterfaceFactory
     */
    private $connectionInterfaceFactory;
    /**
     * @var ConnectionRepositoryInterface
     */
    private $connectionRepository;

    /**
     * Save constructor.
     * @param Context $context
     * @param ConnectionInterfaceFactory $connectionInterfaceFactory
     * @param ConnectionRepositoryInterface $connectionRepository
     */
    public function __construct(
        Context $context,
        ConnectionInterfaceFactory $connectionInterfaceFactory,
        ConnectionRepositoryInterface $connectionRepository
    )
    {
        parent::__construct($context);
        $this->connectionInterfaceFactory = $connectionInterfaceFactory;
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
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($this->_formKeyValidator->validate($this->getRequest())) {
            $params = $this->getRequest()->getParams();
            $params[ConnectionInterface::ID] = (int)$params[ConnectionInterface::ID];
            $password = $params[ConnectionInterface::PASSWORD];
            unset($params[ConnectionInterface::PASSWORD]);

            if ($params[ConnectionInterface::ID]) {
                /** @var \DivideByZero\AutoStockUpdate\Model\Connection $connection */
                $connection = $this->connectionRepository->get($params[ConnectionInterface::ID]);
                $connection->setData($params);
            } else {
                $connection = $this->connectionInterfaceFactory->create(['data' => $params]);
            }

            $connection->setPassword($password);
            $connection = $this->connectionRepository->save($connection);
            return $resultRedirect->setPath('*/*/edit', [ConnectionInterface::ID => $connection->getId()]);
        }

        return $resultRedirect->setPath('*/*/index');
    }
}
