<?php

namespace DivideByZero\AutoStockUpdate\Controller\Adminhtml\Update;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class AbstractUpdate
 * @package DivideByZero\AutoStockUpdate\Controller\Adminhtml\Update
 */
abstract class AbstractUpdate extends \Magento\Backend\App\Action
{
    /**
     * @var PageFactory
     */
    protected $pageFactory;

    /**
     * Index constructor.
     * @param Context $context
     * @param PageFactory $pageFactory
     */
    public function __construct(Context $context, PageFactory $pageFactory)
    {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;
    }

    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return \Magento\Framework\Controller\ResultInterface|\Magento\Framework\App\ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        return $this->pageFactory->create();
    }
}
