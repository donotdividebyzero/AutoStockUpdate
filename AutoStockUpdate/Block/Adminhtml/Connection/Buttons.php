<?php

namespace DivideByZero\AutoStockUpdate\Block\Adminhtml\Connection;

use Magento\Backend\Block\Widget\Container;

/**
 * Class Buttons
 * @package DivideByZero\AutoStockUpdate\Block\Adminhtml\Connection
 */
class Buttons extends Container
{
    /**
     * Prepare button and grid
     *
     * @return \Magento\Backend\Block\Widget\Container
     */
    protected function _prepareLayout()
    {
        $addButtonProps = [
            'id' => 'add_ftp_location',
            'label' => __('Add FTP Location'),
            'class' => 'add',
            'button_class' => '',
            'on_click' => sprintf("location.href = '%s';", $this->getUrl('*/*/edit'))
        ];

        $this->buttonList->add('add_new', $addButtonProps);

        return parent::_prepareLayout();
    }
}
