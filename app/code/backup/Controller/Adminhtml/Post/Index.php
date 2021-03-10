<?php

/**
 * @copyright  Copyright (c) 2021 Jhkinfotech  (https://jhkinfotech.com/)
 */

namespace Jhkinfotech\Ticket\Controller\Adminhtml\Post;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Jhkinfotech\Ticket\Model\TicketFactory;

class Index extends \Magento\Backend\App\Action
{

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        TicketFactory $ticket,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->_ticket = $ticket;
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $ticket = $this->_ticket->create();
        $collection = $ticket->getCollection();
        $collection->addFieldToSelect('read_status');
        $collection->addFieldToFilter('read_status', ['eq' => 'unread']);
        // echo $collection->count();
        
        // foreach($collection as $cunread){
            // if($cunread->getRead_status() == 'unread'){
            //    echo $cunread->getRead_status()."&nbsp;";

            // }
        // }

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Jhkinfotech_Ticket::post');
        $resultPage->addBreadcrumb(__('Support Ticket'), __('Support Ticket'));
        $resultPage->addBreadcrumb(__('Manage Tickets'), __('Manage Tickets'));
        $resultPage->getConfig()->getTitle()->prepend(__('Support Ticket'));

        return $resultPage;
    }

    /**
     * Is the user allowed to view the ticket post grid.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Jhkinfotech_Ticket::post');
    }
}
