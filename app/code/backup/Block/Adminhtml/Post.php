<?php

/**
 * @copyright  Copyright (c) 2021 Jhkinfotech  (https://jhkinfotech.com/)
 */

namespace Jhkinfotech\Ticket\Block\Adminhtml;

class Post extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_controller = 'adminhtml_post';
        $this->_blockGroup = 'Jhkinfotech_Ticket';
        $this->_headerText = __('Manage Tickets');

        parent::_construct();

        if ($this->_isAllowedAction('Jhkinfotech_Ticket::ticket_content')) {
            $this->buttonList->update('add', 'label', __('Add New Ticket'));
        } else {
            $this->buttonList->remove('add');
        }
    }

    protected function _isAllowedAction()
    {
        return $this->_authorization->isAllowed('Jhkinfotech_Ticket::post');
    }
}
