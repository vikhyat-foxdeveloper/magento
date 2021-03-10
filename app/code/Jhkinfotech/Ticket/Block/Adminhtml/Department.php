<?php

/**
 * @copyright  Copyright (c) 2021 Jhkinfotech  (https://jhkinfotech.com/)
 */

namespace Jhkinfotech\Ticket\Block\Adminhtml;

/**
 * Adminhtml cms blocks content block
 */
class Department extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_blockGroup = 'Jhkinfotech_Ticket';
        $this->_controller = 'adminhtml_department';
        $this->_headerText = __('Departments Manager');
        $this->_addButtonLabel = __('Add New Department');
        parent::_construct();
    }
}
