<?php
namespace DivideByZero\AutoStockUpdate\Block\Adminhtml\Connection\Edit\Button;

use Magento\Framework\View\Element\UiComponent\Context;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class Back
 * @package DivideByZero\AutoStockUpdate\Block\Adminhtml\Connection\Edit
 */
class Back implements ButtonProviderInterface
{
    /**
     * @var Context
     */
    private $context;

    /**
     * Back constructor.
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        $this->context = $context;
    }

    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Back'),
            'on_click' => sprintf("location.href = '%s';", $this->context->getUrl('*/*/')),
            'class' => 'back',
            'sort_order' => 10
        ];
    }
}
