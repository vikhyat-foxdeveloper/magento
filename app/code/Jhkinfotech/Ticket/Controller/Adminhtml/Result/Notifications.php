<?php

/**
 * @copyright  Copyright (c) 2021 Jhkinfotech  (https://jhkinfotech.com/)
 */

namespace Jhkinfotech\Ticket\Controller\Adminhtml\Result;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\Result\JsonFactory;
use Jhkinfotech\Ticket\Model\TicketFactory;
use Jhkinfotech\Ticket\Model\ReplyFactory;
use Magento\Framework\Controller\ResultFactory;

class Notifications extends \Magento\Backend\App\Action
{
    public $_ticket;

    public $_reply;

    public $resultPageFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        TicketFactory $ticket,
        ReplyFactory $reply
    ) {
        parent::__construct($context);
        $this->resultPageFactory  = $resultPageFactory;
        $this->_ticket = $ticket;
        $this->_reply = $reply;
        $this->resultJsonFactory = $resultJsonFactory;
    }
    
    public function execute()
    {
        $resultJson = $this->resultJsonFactory->create();

        $ticket = $this->_ticket->create();
        $ticketcollection = $ticket->getCollection();
        $ticketcollection->addFieldToFilter('read_status', ['eq'=>'unread']);
        $ticketunread = $ticketcollection->count();
        
        $reply = $this->_reply->create();
        $collection = $reply->getCollection();
        $collection->addFieldToFilter('read_status', ['eq'=>'unread']);
        $replyunread = $collection->count();
        
        $notification = $replyunread + $ticketunread;        
        $newajax = '<p class="notifications-action" id="jhkinfotech-ticket-alert"><span class="notifications-counter">'.$notification.'</span></p>';
 
        return $resultJson->setData([$newajax]);
    }
}
