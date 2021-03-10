<?php

/**
 * @copyright  Copyright (c) 2021 Jhkinfotech  (https://jhkinfotech.com/)
 */

namespace Jhkinfotech\Ticket\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\Action;
use Magento\Customer\Model\Session;
use Jhkinfotech\Ticket\Model\ReplyFactory;
use Magento\Framework\View\Result\PageFactory;
use Jhkinfotech\Ticket\Model\TicketFactory;
use \Magento\Framework\App\Request\Http;

class Frontreply extends Action
{
    protected $_session;

    protected $_pageFactory;

    protected $_ticket;

    protected $_reply;

    protected $request;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        TicketFactory $ticket,
        ReplyFactory $reply,
        \Magento\Customer\Model\Session $session
    ) {
        $this->_pageFactory = $pageFactory;
        $this->request = $request;
        $this->_ticket = $ticket;
        $this->_reply = $reply;
        $this->_session = $session;
        return parent::__construct($context);
    }
    public function execute()
    {
        $postid = $this->getRequest()->getParam('post_id');

        $reply = $this->_reply->create();
        $collection = $reply->getCollection();
        foreach ($collection as $item) {
            if ($postid == $item->getPost_id()) {
                $savevalue = [$item->getReply_id() => 'read'];
                $item->setData('read_status', $savevalue[$item->getReply_id()]);
                $item->save();
            }
        }
        
        $ticket = $this->_ticket->create();
        $ticket->load($postid);
        $curenr_post_custid = $ticket->getCustomer_id();
        
        $session = $this->_session;
        $customerId = $session->getId();
        
        if ($curenr_post_custid == $customerId) {
            if ($this->_session->isLoggedIn()) {
                $this->_view->loadLayout();
                $this->_view->getLayout()->initMessages();
                $this->_view->renderLayout();
            } else {
                $resultRedirect = $this->resultRedirectFactory->create();
                $resultRedirect->setPath('customer/account/login');
                return $resultRedirect;
            }
        } else {
            
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setPath('ticket/index/formview');
            return $resultRedirect;
        }
    }
}
