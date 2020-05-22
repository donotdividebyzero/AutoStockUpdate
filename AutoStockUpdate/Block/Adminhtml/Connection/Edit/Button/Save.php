<?php
namespace DivideByZero\AutoStockUpdate\Block\Adminhtml\Connection\Edit\Button;


use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class Save
 * @package DivideByZero\AutoStockUpdate\Block\Adminhtml\Connection\Edit
 */
class Save implements ButtonProviderInterface
{
    /**
     * Retrieve button-specified settings
     *
     * @return array
     */
    public function getButtonData(): array
    {
        return [
            'label' => __('Save'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'sort_order' => 90,
        ];
    }
}
