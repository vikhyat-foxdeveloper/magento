<?php

/**
 * @copyright  Copyright (c) 2021 Jhkinfotech  (https://jhkinfotech.com/)
 */

namespace Jhkinfotech\Ticket\Block;

use Magento\Framework\View\Element\Template\Context;
use Jhkinfotech\Ticket\Model\TicketFactory;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;

/**
 * Ticket View block
 */
class Frontreply extends \Magento\Framework\View\Element\Template
{
    protected $_date;

    public function __construct(
        Context $context,
        TicketFactory $ticket
    ) {
        $this->_ticket = $ticket;
        parent::__construct($context);
    }

    public function _prepareLayout()
    {
        $this->pageConfig->getTitle()->set(__('Ticket Reply View'));
        
        return parent::_prepareLayout();
    }
    
    public function getSingleData()
    {
        $id = $this->getRequest()->getParam('post_id');
        $ticket = $this->_ticket->create();
        $singleData = $ticket->load($id);
        return $singleData;
    }
}
